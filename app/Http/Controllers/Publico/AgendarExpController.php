<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Models\AulaExp;
use App\Models\Configuracao;
use App\Models\Horario;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class AgendarExpController extends Controller
{
    protected WhatsAppService $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    /**
     * Exibe o formulário público de agendamento de aula experimental.
     */
    public function index()
    {
        $config = Configuracao::first();

        // Horários disponíveis agrupados por dia
        $horarios = Horario::orderBy('dia_semana')
            ->orderBy('hora_inicio')
            ->get();

        return view('public.agendar-exp', compact('config', 'horarios'));
    }

    /**
     * Salva o agendamento da aula experimental.
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'numero' => ['nullable', 'string', 'max:255'],
            'horario_id' => ['required', 'integer', 'exists:horarios,id'],
            'observacao' => ['nullable', 'string', 'max:500'],
        ], [
            'nome.required' => 'Informe seu nome.',
            'horario_id.required' => 'Selecione um horário.',
            'horario_id.exists' => 'Horário inválido.',
        ]);

        // Busca o horário selecionado para preencher data e dia_semana
        $horario = Horario::findOrFail($dados['horario_id']);

        // Calcula a próxima data do dia da semana selecionado
        $proximaData = $this->calcularProximaData($horario->dia_semana);

        $aulaExp = AulaExp::create([
            'nome' => $dados['nome'],
            'data' => $proximaData,
            'dia_semana' => $horario->dia_semana,
            'horario' => $horario->hora_inicio,
            'numero' => $dados['numero'],
            'observacao' => $dados['observacao'],
        ]);

        // Enviar notificação WhatsApp para o professor
        $this->enviarNotificacaoAulaExp($aulaExp, $horario);

        return redirect()
            ->route('agendar.exp')
            ->with('success', 'Aula experimental agendada com sucesso! Aguarde a confirmação.');
    }

    /**
     * Calcula a próxima data a partir do dia da semana (1=Segunda...7=Domingo).
     */
    private function calcularProximaData(int $diaSemana): Carbon
    {
        $mapa = [
            1 => Carbon::MONDAY,
            2 => Carbon::TUESDAY,
            3 => Carbon::WEDNESDAY,
            4 => Carbon::THURSDAY,
            5 => Carbon::FRIDAY,
            6 => Carbon::SATURDAY,
            7 => Carbon::SUNDAY,
        ];

        return Carbon::today()->next($mapa[$diaSemana]);
    }

    /**
     * Envia notificação WhatsApp para o professor sobre nova aula exp agendada.
     */
    private function enviarNotificacaoAulaExp(AulaExp $aula, Horario $horario): void
    {
        try {
            $numeroWeslei = '5554991538488';

            $mensagem = "🥊 *BOXING HOUSE PF* - Nova Aula EXP Agendada\n\n" .
                       "Olá Weslei! 👋\n\n" .
                       "📋 *Um aluno agendou uma aula experimental pelo site!*\n\n" .
                       "👤 *Nome:* {$aula->nome}\n" .
                       "📞 *Telefone:* " . ($aula->numero ?: 'Não informado') . "\n" .
                       "📅 *Data:* {$aula->data->format('d/m/Y')} ({$horario->dia_semana_label})\n" .
                       "⏰ *Horário:* " . Carbon::parse($aula->horario)->format('H:i') . "\n";

            if ($aula->observacao) {
                $mensagem .= "📝 *Obs:* {$aula->observacao}\n";
            }

            $mensagem .= "\n📈 Acesse o painel para gerenciar as aulas experimentais.\n\n" .
                         "_Notificação automática do sistema_";

            $resultado = $this->whatsAppService->enviarMensagem($numeroWeslei, $mensagem);

            if ($resultado === true) {
                Log::info('Notificação de aula EXP agendada enviada', ['nome' => $aula->nome]);
            } else {
                Log::error('Falha ao enviar notificação de aula EXP', [
                    'nome' => $aula->nome,
                    'erro' => is_array($resultado) ? $resultado['erro'] : 'Erro desconhecido'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Exceção ao enviar notificação de aula EXP', [
                'nome' => $aula->nome ?? 'Desconhecido',
                'erro' => $e->getMessage()
            ]);
        }
    }
}
