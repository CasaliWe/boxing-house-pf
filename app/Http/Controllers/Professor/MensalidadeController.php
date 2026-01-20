<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Configuracao;
use App\Models\User;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MensalidadeController extends Controller
{
    protected WhatsAppService $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    /**
     * Lista alunos inativos por mensalidade vencida
     */
    public function index()
    {
        $alunosInativos = User::where('role', 'aluno')
            ->where('status', 'inativo')
            ->whereNotNull('vencimento_at')
            ->orderBy('vencimento_at', 'desc')
            ->paginate(20);

        return view('professor.mensalidades.index', compact('alunosInativos'));
    }

    /**
     * Reativa aluno e atualiza vencimento
     */
    public function reativar(Request $request, User $user)
    {
        if ($user->role !== 'aluno') {
            return back()->with('error', 'Ação inválida.');
        }

        $dados = $request->validate([
            'novo_vencimento' => ['required', 'date', 'after:today'],
        ]);

        $user->status = 'ativo';
        $user->vencimento_at = $dados['novo_vencimento'];
        $user->save();

        // Enviar WhatsApp de reativação
        if (!empty($user->whatsapp)) {
            $mensagem = $this->criarMensagemReativacao($user, $dados['novo_vencimento']);
            $resultado = $this->whatsAppService->enviarMensagem($user->whatsapp, $mensagem);
            
            if ($resultado !== true) {
                \Log::error('Falha ao enviar WhatsApp de reativação', [
                    'aluno' => $user->name,
                    'whatsapp' => $user->whatsapp,
                    'erro' => $resultado
                ]);
            }
        }

        return back()->with('success', "Aluno {$user->name} reativado com vencimento para " . Carbon::parse($dados['novo_vencimento'])->format('d/m/Y'));
    }

    /**
     * Cria mensagem de reativação
     */
    private function criarMensagemReativacao(User $aluno, string $novoVencimento): string
    {
        // Buscar configurações da academia
        $config = Configuracao::first();
        $whatsappAcademia = $config->whatsapp ?? '(54) 9 9153-8488';
        $emailAcademia = $config->email ?? 'wesleicasali18@gmail.com';
        
        $dataVencimento = Carbon::parse($novoVencimento)->format('d/m/Y');
        
        return "🥊 *BOXING HOUSE PF* 🥊\n\n" .
               "Olá {$aluno->name}! 👋\n\n" .
               "✅ *Parabéns! Sua mensalidade foi regularizada!*\n\n" .
               "🎉 Seu acesso aos treinos foi reativado com sucesso!\n\n" .
               "📅 *Próximo vencimento:* {$dataVencimento}\n\n" .
               "💪 Agora você já pode voltar aos treinos e continuar sua jornada no boxe!\n\n" .
               "📞 *Dúvidas? Entre em contato:*\n" .
               "• WhatsApp: {$whatsappAcademia}\n" .
               "• Email: {$emailAcademia}\n\n" .
               "Te esperamos na academia! 🥊💪\n\n" .
               "_Mensagem enviada automaticamente pelo sistema_";
    }
}