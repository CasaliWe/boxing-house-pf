<?php

namespace App\Services;

use App\Models\Configuracao;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Configurações padrão caso não estejam definidas no banco
     */
    private const DEFAULT_API_URL = '';
    private const DEFAULT_API_TOKEN = '';

    /**
     * Obtém as configurações da API do banco de dados
     */
    private function getApiConfig(): array
    {
        $config = Configuracao::first();
        
        return [
            'url' => $config->whatsapp_api_url ?? self::DEFAULT_API_URL,
            'token' => $config->whatsapp_api_token ?? self::DEFAULT_API_TOKEN,
        ];
    }

    /**
     * Envia mensagem via WhatsApp
     *
     * @param string $numero Número do WhatsApp (formato: 5554991538488)
     * @param string $mensagem Texto da mensagem a ser enviada
     * @return bool|array Retorna true se sucesso, array com erro se falhar
     */
    public function enviarMensagem(string $numero, string $mensagem)
    {
        try {
            // Obtém configurações da API
            $apiConfig = $this->getApiConfig();
            
            // Remove caracteres não numéricos do número
            $numeroLimpo = preg_replace('/\D/', '', $numero);
            
            // Garante que o número tenha o código do Brasil (55) se não tiver
            if (!str_starts_with($numeroLimpo, '55')) {
                $numeroLimpo = '55' . $numeroLimpo;
            }

            Log::info('Enviando WhatsApp', [
                'numero_original' => $numero,
                'numero_limpo' => $numeroLimpo,
                'mensagem' => $mensagem,
                'api_url' => $apiConfig['url']
            ]);

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'token' => $apiConfig['token'],
            ])->post($apiConfig['url'], [
                'number' => $numeroLimpo,
                'text' => $mensagem,
            ]);

            if ($response->successful()) {
                Log::info('WhatsApp enviado com sucesso', [
                    'numero' => $numeroLimpo,
                    'response' => $response->json()
                ]);
                return true;
            } else {
                Log::error('Erro ao enviar WhatsApp', [
                    'numero' => $numeroLimpo,
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                return [
                    'erro' => 'Falha na API',
                    'status' => $response->status(),
                    'detalhes' => $response->body()
                ];
            }

        } catch (\Exception $e) {
            Log::error('Exceção ao enviar WhatsApp', [
                'numero' => $numero,
                'mensagem' => $mensagem,
                'erro' => $e->getMessage()
            ]);
            
            return [
                'erro' => 'Exceção na requisição',
                'detalhes' => $e->getMessage()
            ];
        }
    }

    /**
     * Formatar número brasileiro para WhatsApp
     *
     * @param string $numero
     * @return string
     */
    public function formatarNumero(string $numero): string
    {
        $numeroLimpo = preg_replace('/\D/', '', $numero);
        
        if (!str_starts_with($numeroLimpo, '55')) {
            $numeroLimpo = '55' . $numeroLimpo;
        }
        
        return $numeroLimpo;
    }
}