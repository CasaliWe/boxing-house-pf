<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use App\Models\Horario;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AvisoAulaController extends Controller
{
    protected WhatsAppService $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    /**
     * Envia avisos para alunos com aulas no dia
     */
    public function avisar()
    {
        try {
            // Pegar o dia da semana atual (1 = Segunda, 7 = Domingo)
            $diaSemanaAtual = Carbon::today()->dayOfWeekIso;
            
            Log::info('Iniciando envio de avisos de aulas', [
                'dia_semana' => $diaSemanaAtual,
                'data' => Carbon::today()->format('d/m/Y')
            ]);

            // Buscar todos os horários do dia atual
            $horariosHoje = Horario::where('dia_semana', $diaSemanaAtual)->get();
            
            if ($horariosHoje->isEmpty()) {
                Log::info('Nenhuma aula encontrada para hoje');
                return response()->json([
                    'success' => true,
                    'message' => 'Nenhuma aula encontrada para hoje',
                    'enviados' => 0
                ]);
            }

            $totalEnviados = 0;
            $totalErros = 0;

            // Para cada horário do dia
            foreach ($horariosHoje as $horario) {
                // Buscar alunos aprovados neste horário e que estão ativos
                $alunosAtivos = $horario->alunos()
                    ->wherePivot('aprovado', true)
                    ->where('status', 'ativo')
                    ->whereNotNull('whatsapp')
                    ->get();

                Log::info("Horário {$horario->hora_inicio} - {$horario->dia_semana_label}", [
                    'total_alunos' => $alunosAtivos->count()
                ]);

                // Enviar WhatsApp para cada aluno
                foreach ($alunosAtivos as $aluno) {
                    if (!empty($aluno->whatsapp)) {
                        $mensagem = $this->criarMensagemAvisoAula($aluno, $horario);
                        $resultado = $this->whatsAppService->enviarMensagem($aluno->whatsapp, $mensagem);
                        
                        if ($resultado === true) {
                            $totalEnviados++;
                            Log::info("✅ Aviso enviado", [
                                'aluno' => $aluno->name,
                                'horario' => $horario->hora_inicio
                            ]);
                        } else {
                            $totalErros++;
                            Log::error("❌ Falha ao enviar aviso", [
                                'aluno' => $aluno->name,
                                'whatsapp' => $aluno->whatsapp,
                                'horario' => $horario->hora_inicio,
                                'erro' => is_array($resultado) ? $resultado['erro'] : 'Erro desconhecido'
                            ]);
                        }
                    }
                }
            }

            Log::info('Avisos de aulas concluídos', [
                'total_enviados' => $totalEnviados,
                'total_erros' => $totalErros
            ]);

            return response()->json([
                'success' => true,
                'message' => "Avisos processados com sucesso",
                'enviados' => $totalEnviados,
                'erros' => $totalErros,
                'horarios_processados' => $horariosHoje->count()
            ]);

        } catch (\Exception $e) {
            Log::error('Erro ao processar avisos de aulas', [
                'erro' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro ao processar avisos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cria mensagem de aviso de aula
     */
    private function criarMensagemAvisoAula($aluno, $horario): string
    {
        // Buscar configurações da academia
        $config = Configuracao::first();
        $whatsappAcademia = $config->whatsapp ?? '(54) 9 9153-8488';
        
        // Formatar horário
        $horaInicio = Carbon::parse($horario->hora_inicio)->format('H:i');
        $horaFim = Carbon::parse($horario->hora_fim)->format('H:i');
        
        return "🥊 *BOXING HOUSE PF* 🥊\n\n" .
               "Bom dia {$aluno->name}! ☀️\n\n" .
               "🔔 *Lembrete: Você tem treino hoje!*\n\n" .
               "📅 *Hoje:* " . Carbon::today()->format('d/m/Y') . " ({$horario->dia_semana_label})\n" .
               "⏰ *Horário:* {$horaInicio} às {$horaFim}\n\n" .
               "💪 Prepare-se para mais um dia de treino intenso!\n" .
               "🥤 Não esqueça de levar água e uma toalha.\n\n" .
               "📞 *Dúvidas ou imprevistos:*\n" .
               "• WhatsApp: {$whatsappAcademia}\n\n" .
               "Nos vemos em breve! 🔥\n\n" .
               "_Mensagem enviada automaticamente pelo sistema_";
    }
}