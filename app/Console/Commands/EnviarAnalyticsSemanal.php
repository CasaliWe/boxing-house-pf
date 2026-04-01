<?php

namespace App\Console\Commands;

use App\Models\AnalyticsEvento;
use App\Services\WhatsAppService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class EnviarAnalyticsSemanal extends Command
{
    protected WhatsAppService $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        parent::__construct();
        $this->whatsAppService = $whatsAppService;
    }

    protected $signature = 'analytics:semanal';

    protected $description = 'Envia relatório semanal de analytics da landing page via WhatsApp';

    public function handle()
    {
        $inicio = Carbon::now()->subDays(7)->startOfDay();
        $fim = Carbon::now();

        $eventos = AnalyticsEvento::where('created_at', '>=', $inicio)->get();

        if ($eventos->isEmpty()) {
            $this->info('Nenhum evento de analytics nos últimos 7 dias. WhatsApp não enviado.');
            return Command::SUCCESS;
        }

        // Visitas totais e únicas
        $visitas = $eventos->where('tipo', 'visita');
        $visitasTotal = $visitas->count();
        $visitasUnicas = $visitas->unique('sessao_id')->count();

        // Cliques WhatsApp por botão
        $cliquesWhatsApp = $eventos->where('tipo', 'clique_whatsapp');
        $totalWhatsApp = $cliquesWhatsApp->count();
        $whatsAppPorBotao = $cliquesWhatsApp->groupBy('nome')->map->count()->sortDesc();

        // Cliques Login por botão
        $cliquesLogin = $eventos->where('tipo', 'clique_login');
        $totalLogin = $cliquesLogin->count();
        $loginPorBotao = $cliquesLogin->groupBy('nome')->map->count()->sortDesc();

        // Montar mensagem
        $mensagem = "📊 *BOXING HOUSE PF* - Analytics Semanal\n\n";
        $mensagem .= "📅 *{$inicio->format('d/m')} a {$fim->format('d/m/Y')}*\n\n";

        $mensagem .= "👁️ *Visitas na Landing Page:*\n";
        $mensagem .= "   Total: {$visitasTotal}\n";
        $mensagem .= "   Únicas: {$visitasUnicas}\n\n";

        $mensagem .= "💬 *Cliques WhatsApp:* {$totalWhatsApp}\n";
        if ($whatsAppPorBotao->isNotEmpty()) {
            foreach ($whatsAppPorBotao as $botao => $qtd) {
                $mensagem .= "   • {$botao}: {$qtd}\n";
            }
        }
        $mensagem .= "\n";

        $mensagem .= "🔑 *Cliques Área do Aluno:* {$totalLogin}\n";
        if ($loginPorBotao->isNotEmpty()) {
            foreach ($loginPorBotao as $botao => $qtd) {
                $mensagem .= "   • {$botao}: {$qtd}\n";
            }
        }
        $mensagem .= "\n";

        // Taxa de conversão
        if ($visitasTotal > 0) {
            $taxaWhatsApp = round(($totalWhatsApp / $visitasTotal) * 100, 1);
            $mensagem .= "📈 *Taxa de conversão:*\n";
            $mensagem .= "   Visita → WhatsApp: {$taxaWhatsApp}%\n\n";
        }

        $mensagem .= "_Relatório automático semanal_";

        $numeroWeslei = '5554991538488';
        $resultado = $this->whatsAppService->enviarMensagem($numeroWeslei, $mensagem);

        if ($resultado === true) {
            $this->info('✅ Relatório de analytics enviado com sucesso!');
        } else {
            $this->error('❌ Falha ao enviar: ' . (is_array($resultado) ? $resultado['erro'] : 'Erro desconhecido'));
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
