<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Mail\CredenciaisAlunoMail;
use App\Models\Horario;
use App\Models\User;
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

        $msg = 'Aluno aprovado! Vagas confirmadas.';
        // Mensagem simplificada para manter organização visual

        $redirect = redirect()->route('professor.aprovacoes.index')->with('success', $msg);
        if ($emailFalhou) {
            $redirect->with('warning', 'Aluno aprovado, porém o e-mail de credenciais não pôde ser enviado. Verifique as configurações de e-mail.');
        }
        return $redirect;
    }
}
