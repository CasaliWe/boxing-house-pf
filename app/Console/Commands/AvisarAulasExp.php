<?php

namespace App\Console\Commands;

use App\Models\AulaExp;
use App\Services\WhatsAppService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class AvisarAulasExp extends Command
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
    protected $signature = 'aulas-exp:avisar';

    /**
     * The console command description.
     */
    protected $description = 'Envia aviso das aulas experimentais do dia para o professor via WhatsApp';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hoje = Carbon::today();

        // Buscar aulas EXP agendadas para hoje
        $aulasHoje = AulaExp::whereDate('data', $hoje)
            ->orderBy('horario')
            ->get();

        if ($aulasHoje->isEmpty()) {
            $this->info('Nenhuma aula EXP hoje.');
            return Command::SUCCESS;
        }

        // Montar mensagem
        $linhasAulas = [];
        foreach ($aulasHoje as $aula) {
            $horario = Carbon::parse($aula->horario)->format('H:i');
            $linhasAulas[] = "⏰ *{$horario}* - {$aula->nome}";
            if ($aula->numero) {
                $linhasAulas[] = "   📞 {$aula->numero}";
            }
            if ($aula->observacao) {
                $linhasAulas[] = "   📝 {$aula->observacao}";
            }
            $linhasAulas[] = '';
        }

        $mensagem = "🥊 *BOXING HOUSE PF* - Aulas EXP do Dia\n\n" .
                   "Olá Weslei! 👋\n\n" .
                   "📅 *{$hoje->format('d/m/Y')}*\n\n" .
                   "🆕 *Aulas experimentais de hoje:*\n\n" .
                   implode("\n", $linhasAulas) .
                   "Total: {$aulasHoje->count()} aula(s) EXP\n\n" .
                   "_Notificação automática do sistema_";

        // Número do Weslei (hardcoded, mesmo padrão do sistema)
        $numeroWeslei = '5554991538488';
        $resultado = $this->whatsAppService->enviarMensagem($numeroWeslei, $mensagem);

        if ($resultado === true) {
            $this->info("✅ Aviso de aulas EXP enviado! ({$aulasHoje->count()} aulas)");
        } else {
            $this->error('❌ Falha ao enviar: ' . (is_array($resultado) ? $resultado['erro'] : 'Erro desconhecido'));
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
