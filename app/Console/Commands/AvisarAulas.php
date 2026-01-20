<?php

namespace App\Console\Commands;

use App\Http\Controllers\AvisoAulaController;
use App\Services\WhatsAppService;
use Illuminate\Console\Command;

class AvisarAulas extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'aulas:avisar';

    /**
     * The console command description.
     */
    protected $description = 'Envia avisos WhatsApp para alunos com aulas no dia';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔔 Iniciando envio de avisos de aulas...');
        
        try {
            $whatsAppService = app(WhatsAppService::class);
            $controller = new AvisoAulaController($whatsAppService);
            $response = $controller->avisar();
            
            $data = $response->getData(true);
            
            if ($data['success']) {
                $this->info("✅ Avisos processados com sucesso!");
                $this->line("📤 Mensagens enviadas: {$data['enviados']}");
                $this->line("❌ Erros: {$data['erros']}");
                $this->line("📅 Horários processados: {$data['horarios_processados']}");
            } else {
                $this->error("❌ Erro: {$data['message']}");
                return Command::FAILURE;
            }
            
        } catch (\Exception $e) {
            $this->error("❌ Erro ao processar avisos: {$e->getMessage()}");
            return Command::FAILURE;
        }
        
        return Command::SUCCESS;
    }
}