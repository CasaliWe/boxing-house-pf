<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\WhatsAppService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ParabensAniversario extends Command
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
    protected $signature = 'aniversario:parabenizar';

    /**
     * The console command description.
     */
    protected $description = 'Envia parabéns via WhatsApp para alunos aniversariantes do dia';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hoje = Carbon::today();

        // Busca alunos ativos que fazem aniversário hoje (mesmo dia e mês)
        $aniversariantes = User::where('role', 'aluno')
            ->where('status', 'ativo')
            ->whereNotNull('data_nascimento')
            ->whereNotNull('whatsapp')
            ->whereMonth('data_nascimento', $hoje->month)
            ->whereDay('data_nascimento', $hoje->day)
            ->get();

        if ($aniversariantes->isEmpty()) {
            $this->info('Nenhum aniversariante hoje.');
            return Command::SUCCESS;
        }

        $enviados = 0;
        $erros = 0;

        foreach ($aniversariantes as $aluno) {
            $mensagem = $this->criarMensagemParabens($aluno);
            $resultado = $this->whatsAppService->enviarMensagem($aluno->whatsapp, $mensagem);

            if ($resultado === true) {
                $enviados++;
                $this->info("✅ Parabéns enviado para {$aluno->name}");
            } else {
                $erros++;
                $this->error("❌ Falha ao enviar para {$aluno->name}: " . (is_array($resultado) ? $resultado['erro'] : 'Erro desconhecido'));
            }
        }

        $this->info("Parabéns enviados: {$enviados} | Erros: {$erros}");

        return Command::SUCCESS;
    }

    /**
     * Cria mensagem de parabéns para o aluno
     */
    private function criarMensagemParabens(User $aluno): string
    {
        return "🥊 *BOXING HOUSE PF* 🥊\n\n" .
               "Feliz aniversário, {$aluno->name}! 🎉🎂\n\n" .
               "Que esse novo ano venha com muita saúde, força e dedicação dentro e fora do ringue! 💪\n\n" .
               "Parabéns de toda a equipe da Boxing House PF! 🏆\n\n" .
               "_Mensagem enviada automaticamente pelo sistema_";
    }
}
