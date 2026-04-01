<?php

namespace App\Console\Commands;

use App\Models\Horario;
use App\Services\WhatsAppService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class AvisarTurmasDia extends Command
{
    protected WhatsAppService $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        parent::__construct();
        $this->whatsAppService = $whatsAppService;
    }

    /**
     * The name and signature of the console command.
     */
    protected $signature = 'turmas:avisar';

    /**
     * The console command description.
     */
    protected $description = 'Envia resumo das turmas do dia para o professor via WhatsApp';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hoje = Carbon::today();
        $diaSemana = $hoje->dayOfWeekIso; // 1=Segunda ... 7=Domingo

        // Buscar horários do dia com alunos ativos e aprovados
        $horariosHoje = Horario::where('dia_semana', $diaSemana)
            ->orderBy('hora_inicio')
            ->get();

        if ($horariosHoje->isEmpty()) {
            $this->info('Nenhuma turma hoje.');
            return Command::SUCCESS;
        }

        // Montar mensagem
        $linhasTurmas = [];
        foreach ($horariosHoje as $horario) {
            $alunos = $horario->alunos()
                ->wherePivot('aprovado', true)
                ->where('status', 'ativo')
                ->orderBy('name')
                ->get();

            $horaInicio = Carbon::parse($horario->hora_inicio)->format('H:i');
            $horaFim = Carbon::parse($horario->hora_fim)->format('H:i');

            $linhasTurmas[] = "⏰ *{$horaInicio} - {$horaFim}* ({$alunos->count()}/{$horario->limite_alunos} alunos)";

            if ($alunos->isNotEmpty()) {
                foreach ($alunos as $aluno) {
                    $linhasTurmas[] = "   • {$aluno->name}";
                }
            } else {
                $linhasTurmas[] = "   _Nenhum aluno nesta turma_";
            }
            $linhasTurmas[] = '';
        }

        $mensagem = "🥊 *BOXING HOUSE PF* - Turmas do Dia\n\n" .
                   "Bom dia Weslei! 👋\n\n" .
                   "📅 *{$hoje->format('d/m/Y')}* ({$horariosHoje->first()->dia_semana_label})\n\n" .
                   "📋 *Suas turmas de hoje:*\n\n" .
                   implode("\n", $linhasTurmas) .
                   "Total: {$horariosHoje->count()} turma(s)\n\n" .
                   "_Notificação automática do sistema_";

        // Número do Weslei (hardcoded, mesmo padrão do sistema)
        $numeroWeslei = '5554991538488';
        $resultado = $this->whatsAppService->enviarMensagem($numeroWeslei, $mensagem);

        if ($resultado === true) {
            $this->info('✅ Resumo das turmas enviado com sucesso!');
        } else {
            $this->error('❌ Falha ao enviar: ' . (is_array($resultado) ? $resultado['erro'] : 'Erro desconhecido'));
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
