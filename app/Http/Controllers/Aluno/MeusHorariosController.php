<?php

namespace App\Http\Controllers\Aluno;

use App\Http\Controllers\Controller;
use App\Models\Horario;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class MeusHorariosController extends Controller
{
    protected WhatsAppService $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    public function index()
    {
        $user = auth()->user()->load(['horarios' => function($q){
            $q->orderBy('dia_semana')->orderBy('hora_inicio');
        }]);
        $horarios = Horario::orderBy('dia_semana')->orderBy('hora_inicio')->get();

        return view('aluno.horarios.index', compact('user', 'horarios'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'horarios' => ['array'],
            'horarios.*' => ['integer', 'exists:horarios,id'],
        ]);

        $selecionados = collect($data['horarios'] ?? []);

        // Limite do plano
        $max = (int)($user->plano_vezes ?? 0);
        if ($max > 0 && $selecionados->count() > $max) {
            return back()->withErrors(['horarios' => 'Você só pode selecionar '.$max.' horário(s) conforme seu plano.'])->withInput();
        }

        // Aprovação conforme vagas
        $atuais = $user->horarios()->get()->keyBy('id');
        $syncData = [];
        foreach (Horario::whereIn('id', $selecionados)->get() as $h) {
            $aprovadoAtual = $atuais->has($h->id) ? (bool)($atuais[$h->id]->pivot->aprovado) : false;
            $ocupadas = $h->alunos()->wherePivot('aprovado', true)
                ->when($atuais->has($h->id) && $aprovadoAtual, function($q) use ($user){
                    $q->where('users.id', '!=', $user->id);
                })
                ->count();
            $syncData[$h->id] = ['aprovado' => $ocupadas < $h->limite_alunos];
        }

        $user->horarios()->sync($syncData);

        // Enviar notificação para Weslei sobre mudança de horários
        $this->enviarNotificacaoMudancaHorarios($user, $selecionados, $syncData);

        $semVaga = [];
        foreach ($syncData as $hid => $pivot) {
            if (!$pivot['aprovado']) {
                $h = $atuais->get($hid) ?: Horario::find($hid);
                if ($h) {
                    $semVaga[] = $h->dia_semana_label.' '.Carbon::parse($h->hora_inicio)->format('H:i');
                }
            }
        }

        $msg = 'Seus horários foram atualizados.';
        if (!empty($semVaga)) {
            $msg .= ' Sem vagas em: '.implode(', ', $semVaga).'.';
        }

        return back()->with('success', $msg);
    }

    /**
     * Envia notificação WhatsApp para Weslei sobre mudança de horários
     */
    private function enviarNotificacaoMudancaHorarios($aluno, $horariosEscolhidos, $syncData)
    {
        try {
            // Número do Weslei (hardcoded)
            $numeroWeslei = '5554991538488';
            
            // Buscar detalhes dos horários escolhidos
            $horariosDetalhes = Horario::whereIn('id', $horariosEscolhidos)
                ->orderBy('dia_semana')
                ->orderBy('hora_inicio')
                ->get();
            
            if ($horariosDetalhes->isEmpty()) {
                return;
            }
            
            $listaHorarios = [];
            foreach ($horariosDetalhes as $horario) {
                $aprovado = $syncData[$horario->id]['aprovado'] ? '✅' : '⏳';
                $horaInicio = Carbon::parse($horario->hora_inicio)->format('H:i');
                $horaFim = Carbon::parse($horario->hora_fim)->format('H:i');
                $listaHorarios[] = "{$aprovado} {$horario->dia_semana_label} - {$horaInicio} às {$horaFim}";
            }
            
            $mensagem = "🥊 *BOXING HOUSE PF* - Notificação\n\n" .
                       "Olá Weslei! 👋\n\n" .
                       "📅 *Aluno alterou seus horários:*\n" .
                       "👤 *Nome:* {$aluno->name}\n" .
                       "📧 *Email:* {$aluno->email}\n\n" .
                       "⏰ *Novos horários escolhidos:*\n" .
                       implode("\n", $listaHorarios) . "\n\n" .
                       "✅ Aprovado automaticamente\n" .
                       "⏳ Aguardando vaga\n\n" .
                       "_Notificação automática do sistema_";
            
            $resultado = $this->whatsAppService->enviarMensagem($numeroWeslei, $mensagem);
            
            if ($resultado === true) {
                Log::info('Notificação de mudança de horários enviada', [
                    'aluno' => $aluno->name,
                    'horarios_count' => $horariosDetalhes->count()
                ]);
            } else {
                Log::error('Falha ao enviar notificação de mudança de horários', [
                    'aluno' => $aluno->name,
                    'erro' => is_array($resultado) ? $resultado['erro'] : 'Erro desconhecido'
                ]);
            }
            
        } catch (\Exception $e) {
            Log::error('Exceção ao enviar notificação de mudança de horários', [
                'aluno' => $aluno->name ?? 'Desconhecido',
                'erro' => $e->getMessage()
            ]);
        }
    }
}
