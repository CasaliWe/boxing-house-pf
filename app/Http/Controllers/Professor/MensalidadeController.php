<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Configuracao;
use App\Models\User;
use App\Models\ValorPlano;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class MensalidadeController extends Controller
{
    protected WhatsAppService $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    /**
     * Lista alunos que precisam de novo pacote ou reativacao.
     */
    public function index()
    {
        $alunosInativos = User::where('role', 'aluno')
            ->where(function ($query) {
                $query->where('status', 'inativo')
                    ->orWhere(function ($saldo) {
                        $saldo->where('status', 'ativo')
                            ->where('aulas_contratadas', '>', 0)
                            ->where('aulas_restantes', '<=', 0);
                    });
            })
            ->orderBy('name')
            ->paginate(20);
        $pacotes = ValorPlano::pacotes()->orderBy('aulas_mes')->get();

        return view('professor.mensalidades.index', compact('alunosInativos', 'pacotes'));
    }

    /**
     * Adiciona novo pacote de aulas ao aluno.
     */
    public function reativar(Request $request, User $user)
    {
        if ($user->role !== 'aluno') {
            return back()->with('error', 'Ação inválida.');
        }

        if ($request->filled('valor_aula')) {
            $request->merge([
                'valor_aula' => str_replace(',', '.', $request->input('valor_aula')),
            ]);
        }

        $dados = $request->validate([
            'aulas_contratadas' => ['required', 'integer', 'min:1', 'max:100'],
            'valor_aula' => ['nullable', 'numeric', 'min:0'],
        ]);

        $aulas = (int) $dados['aulas_contratadas'];
        $pacote = ValorPlano::pacoteParaQuantidade($aulas);
        $valorAula = isset($dados['valor_aula'])
            ? (float) $dados['valor_aula']
            : (float) ($pacote?->valor_aula ?? 0);

        $user->status = 'ativo';
        $user->registrarPacoteAulas($aulas, $valorAula, $aulas);

        // Registra a entrada financeira do novo pacote
        if ($aulas > 0 && $valorAula > 0) {
            MovimentacaoController::registrarEntradaPacote($user, $aulas, $valorAula, 'novo pacote / reativação');
        }

        if (!empty($user->whatsapp)) {
            $mensagem = $this->criarMensagemNovoPacote($user);
            $resultado = $this->whatsAppService->enviarMensagem($user->whatsapp, $mensagem);

            if ($resultado !== true) {
                \Log::error('Falha ao enviar WhatsApp de novo pacote de aulas', [
                    'aluno' => $user->name,
                    'whatsapp' => $user->whatsapp,
                    'erro' => $resultado,
                ]);
            }
        }

        return back()->with('success', "Pacote de {$aulas} aula(s) adicionado para {$user->name}.");
    }

    private function criarMensagemNovoPacote(User $aluno): string
    {
        $config = Configuracao::first();
        $whatsappAcademia = $config->whatsapp ?? '(54) 9 9153-8488';
        $valorAula = number_format((float) $aluno->valor_aula, 2, ',', '.');
        $valorTotal = number_format((float) $aluno->valor_total_aulas, 2, ',', '.');

        return "🥊 *BOXING HOUSE PF* 🥊\n\n" .
            "Olá {$aluno->name}! 👋\n\n" .
            "✅ *Seu novo pacote de aulas foi registrado!*\n\n" .
            "📅 *Aulas contratadas:* {$aluno->aulas_contratadas}\n" .
            "💰 *Valor por aula:* R$ {$valorAula}\n" .
            "💰 *Total:* R$ {$valorTotal}\n\n" .
            "Seu saldo ja esta disponível no sistema.\n\n" .
            "Dúvidas ou imprevistos? Chame no WhatsApp: {$whatsappAcademia}\n\n" .
            "_Mensagem enviada automaticamente pelo sistema_";
    }
}
