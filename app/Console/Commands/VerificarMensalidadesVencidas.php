<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Configuracao;
use App\Services\WhatsAppService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class VerificarMensalidadesVencidas extends Command
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
    protected $signature = 'mensalidade:verificar';

    /**
     * The console command description.
     */
    protected $description = 'Verifica mensalidades vencidas e torna alunos inativos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hoje = Carbon::today();
        
        // Busca alunos ativos com mensalidade vencida
        $alunosVencidos = User::where('role', 'aluno')
            ->where('status', 'ativo')
            ->whereNotNull('vencimento_at')
            ->whereDate('vencimento_at', '<', $hoje)
            ->get();

        $contador = 0;
        
        foreach ($alunosVencidos as $aluno) {
            // Tornar o aluno inativo
            $aluno->status = 'inativo';
            $aluno->save();
            $contador++;
            
            // Enviar WhatsApp de aviso
            if (!empty($aluno->whatsapp)) {
                $mensagem = $this->criarMensagemVencimento($aluno);
                $resultado = $this->whatsAppService->enviarMensagem($aluno->whatsapp, $mensagem);
                
                if ($resultado === true) {
                    $this->info("✅ WhatsApp enviado para {$aluno->name} - Vencimento: {$aluno->vencimento_at->format('d/m/Y')}");
                } else {
                    $this->error("❌ Falha ao enviar WhatsApp para {$aluno->name}: " . (is_array($resultado) ? $resultado['erro'] : 'Erro desconhecido'));
                }
            } else {
                $this->warn("⚠️ {$aluno->name} não possui WhatsApp cadastrado");
            }
            
            $this->info("Aluno {$aluno->name} ({$aluno->email}) tornado inativo - Vencimento: {$aluno->vencimento_at->format('d/m/Y')}");
        }

        $this->info("Total de alunos tornados inativos por mensalidade vencida: {$contador}");
        
        return Command::SUCCESS;
    }

    /**
     * Cria mensagem de aviso sobre mensalidade vencida
     */
    private function criarMensagemVencimento(User $aluno): string
    {
        $diasVencidos = Carbon::today()->diffInDays($aluno->vencimento_at);
        
        // Buscar configurações da academia
        $config = Configuracao::first();
        $whatsappAcademia = $config->whatsapp ?? '(54) 9 9153-8488';
        $emailAcademia = $config->email ?? 'wesleicasali18@gmail.com';
        
        return "🥊 *BOXING HOUSE PF* 🥊\n\n" .
               "Olá {$aluno->name}! 👋\n\n" .
               "⚠️ *Sua mensalidade está vencida há {$diasVencidos} dia(s)*\n\n" .
               "📅 *Vencimento:* {$aluno->vencimento_at->format('d/m/Y')}\n\n" .
               "💳 Para regularizar sua situação e reativar seus treinos, faça o pagamento da mensalidade.\n\n" .
               "📞 *Entre em contato conosco:*\n" .
               "• WhatsApp: {$whatsappAcademia}\n" .
               "• Email: {$emailAcademia}\n\n" .
               "Estamos aguardando seu retorno para que você possa continuar seus treinos! 💪\n\n" .
               "_Mensagem enviada automaticamente pelo sistema_";
    }
}
