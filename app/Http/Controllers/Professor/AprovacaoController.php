<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Mail\CredenciaisAlunoMail;
use App\Models\Horario;
use App\Models\User;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AprovacaoController extends Controller
{
    public function index()
    {
        $pendentes = User::where('role', 'aluno')
            ->where('status', 'pendente')
            ->with(['horarios' => function($q){
                $q->orderBy('dia_semana')->orderBy('hora_inicio');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Lista de horários para uso no modal de atualização
        $horarios = Horario::orderBy('dia_semana')->orderBy('hora_inicio')->get();

        return view('professor.aprovacoes.index', compact('pendentes', 'horarios'));
    }

    public function aprovar(Request $request, User $user)
    {
        if ($user->role !== 'aluno' || $user->status !== 'pendente') {
            return back()->with('error', 'Usuário inválido para aprovação.');
        }

        // Antes de aprovar, validar disponibilidade dos horários escolhidos
        $horariosSelecionados = $user->horarios()->get();
        $semVaga = [];
        foreach ($horariosSelecionados as $h) {
            $ocupadas = $h->alunos()->wherePivot('aprovado', true)->count();
            if ($ocupadas >= Horario::LIMITE_ALUNOS) {
                $semVaga[] = $h->dia_semana_label.' '.\Illuminate\Support\Carbon::parse($h->hora_inicio)->format('H:i');
            }
        }
        if (!empty($semVaga)) {
            return back()->with('error', 'Não foi possível aprovar. Sem vagas em: '.implode(', ', $semVaga).'. Atualize os horários do aluno antes de aprovar.');
        }

        // Gerar senha inicial: nome (sem espaços, minúsculo) + 123
        $base = Str::lower(Str::of($user->name)->replace(' ', ''));
        $plain = $base.'123';
        $user->password = Hash::make($plain);
        $user->status = 'ativo';
        $user->vencimento_at = $user->vencimento_at ?: Carbon::now()->addDays(30)->toDateString();
        $user->save();

        // Aprovar horários (agora já garantimos disponibilidade acima)
        $aprovados = [];
        $horarios = $user->horarios()->get();
        foreach ($horarios as $h) {
            // apenas se ainda não aprovado
            $pivot = $h->alunos()->where('users.id', $user->id)->first();
            $jaAprovado = $pivot && $pivot->pivot && $pivot->pivot->aprovado;
            if ($jaAprovado) {
                continue;
            }
            $user->horarios()->updateExistingPivot($h->id, ['aprovado' => true]);
            $aprovados[] = $h->dia_semana_label.' '.\Illuminate\Support\Carbon::parse($h->hora_inicio)->format('H:i');
        }

        // Tentar enviar e-mail com credenciais
        $emailFalhou = false;
        try {
            Mail::to($user->email)->send(new CredenciaisAlunoMail($user, $plain));
        } catch (\Throwable $e) {
            $emailFalhou = true;
            Log::error('Falha ao enviar e-mail de credenciais: '.$e->getMessage());
        }

        // Enviar WhatsApp com as credenciais
        $whatsappFalhou = false;
        if ($user->whatsapp) {
            try {
                $whatsappService = new WhatsAppService();
                $mensagemWhatsApp = "🥊 *Bem-vindo à Boxing House PF!* 🥊\n\n"
                    . "Olá {$user->name}! Seu cadastro foi aprovado e seu acesso ao sistema está liberado.\n\n"
                    . "📱 *Suas credenciais de acesso:*\n"
                    . "Login: {$user->email}\n"
                    . "Senha inicial: {$plain}\n\n"
                    . "🔒 Por segurança, altere sua senha após o primeiro acesso.\n\n"
                    . "🌐 Acesse em: " . config('app.url') . "\n\n"
                    . "Qualquer dúvida, entre em contato conosco!";

                $resultado = $whatsappService->enviarMensagem($user->whatsapp, $mensagemWhatsApp);
                
                if ($resultado !== true) {
                    $whatsappFalhou = true;
                    Log::warning('Falha ao enviar WhatsApp de credenciais', [
                        'user_id' => $user->id,
                        'whatsapp' => $user->whatsapp,
                        'erro' => $resultado
                    ]);
                }
            } catch (\Throwable $e) {
                $whatsappFalhou = true;
                Log::error('Exceção ao enviar WhatsApp de credenciais: '.$e->getMessage(), [
                    'user_id' => $user->id,
                    'whatsapp' => $user->whatsapp
                ]);
            }
        }

        $msg = 'Aluno aprovado! Vagas confirmadas.';
        // Adiciona informações sobre envios
        $avisos = [];
        if ($emailFalhou) {
            $avisos[] = 'E-mail não pôde ser enviado';
        }
        if ($whatsappFalhou) {
            $avisos[] = 'WhatsApp não pôde ser enviado';
        }

        $redirect = redirect()->route('professor.aprovacoes.index')->with('success', $msg);
        
        if (!empty($avisos)) {
            $redirect->with('warning', 'Aluno aprovado, porém: ' . implode(', ', $avisos) . '. Verifique as configurações.');
        }
        
        return $redirect;
    }
}
