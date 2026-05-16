<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Movimentacao;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MovimentacaoController extends Controller
{
    /**
     * Lista movimentações com filtros de tipo / status / mês.
     */
    public function index(Request $request)
    {
        // Atualiza status de atraso de todas as movimentações em aberto
        $this->recalcularAtrasos();

        $tipo   = $request->get('tipo');   // entrada | saida | null (todos)
        $status = $request->get('status'); // aberto | atraso | pago | null
        $mes    = $request->get('mes', Carbon::now()->format('Y-m'));

        // Define intervalo do mês selecionado
        try {
            $inicioMes = Carbon::createFromFormat('Y-m', $mes)->startOfMonth();
        } catch (\Throwable $e) {
            $inicioMes = Carbon::now()->startOfMonth();
            $mes       = $inicioMes->format('Y-m');
        }
        $fimMes = $inicioMes->copy()->endOfMonth();

        $query = Movimentacao::with('user:id,name,email')
            ->whereBetween('data_vencimento', [$inicioMes, $fimMes])
            ->orderByDesc('data_vencimento')
            ->orderByDesc('id');

        if (in_array($tipo, [Movimentacao::TIPO_ENTRADA, Movimentacao::TIPO_SAIDA], true)) {
            $query->where('tipo', $tipo);
        }
        if (in_array($status, [Movimentacao::STATUS_ABERTO, Movimentacao::STATUS_ATRASO, Movimentacao::STATUS_PAGO], true)) {
            $query->where('status', $status);
        }

        $movimentacoes = $query->paginate(20)->withQueryString();

        // Totalizadores do mês
        $entradasMes = (float) Movimentacao::entradas()
            ->whereBetween('data_vencimento', [$inicioMes, $fimMes])
            ->sum('valor');
        $saidasMes = (float) Movimentacao::saidas()
            ->whereBetween('data_vencimento', [$inicioMes, $fimMes])
            ->sum('valor');
        $aReceberMes = (float) Movimentacao::entradas()
            ->whereBetween('data_vencimento', [$inicioMes, $fimMes])
            ->whereIn('status', [Movimentacao::STATUS_ABERTO, Movimentacao::STATUS_ATRASO])
            ->sum('valor');
        $aPagarMes = (float) Movimentacao::saidas()
            ->whereBetween('data_vencimento', [$inicioMes, $fimMes])
            ->whereIn('status', [Movimentacao::STATUS_ABERTO, Movimentacao::STATUS_ATRASO])
            ->sum('valor');

        return view('professor.movimentacoes.index', [
            'movimentacoes' => $movimentacoes,
            'tipoFiltro'    => $tipo,
            'statusFiltro'  => $status,
            'mesFiltro'     => $mes,
            'mesLabel'      => $inicioMes->translatedFormat('F \\d\\e Y'),
            'entradasMes'   => $entradasMes,
            'saidasMes'     => $saidasMes,
            'aReceberMes'   => $aReceberMes,
            'aPagarMes'     => $aPagarMes,
            'saldoMes'      => $entradasMes - $saidasMes,
        ]);
    }

    /**
     * Formulário de nova movimentação.
     */
    public function create(Request $request)
    {
        $tipo   = $request->get('tipo', Movimentacao::TIPO_ENTRADA);
        $alunos = User::where('role', 'aluno')->orderBy('name')->get(['id', 'name', 'email']);

        return view('professor.movimentacoes.create', compact('tipo', 'alunos'));
    }

    /**
     * Persiste nova movimentação.
     */
    public function store(Request $request)
    {
        $dados = $this->validarMovimentacao($request);
        Movimentacao::create($dados);

        return redirect()
            ->route('professor.movimentacoes.index', ['tipo' => $dados['tipo']])
            ->with('success', 'Movimentação registrada com sucesso.');
    }

    /**
     * Formulário de edição.
     */
    public function edit(Movimentacao $movimentaco)
    {
        $movimentacao = $movimentaco; // alias para legibilidade
        $alunos = User::where('role', 'aluno')->orderBy('name')->get(['id', 'name', 'email']);
        return view('professor.movimentacoes.edit', compact('movimentacao', 'alunos'));
    }

    /**
     * Atualiza movimentação.
     */
    public function update(Request $request, Movimentacao $movimentaco)
    {
        $dados = $this->validarMovimentacao($request);
        $movimentaco->update($dados);

        return redirect()
            ->route('professor.movimentacoes.index', ['tipo' => $movimentaco->tipo])
            ->with('success', 'Movimentação atualizada.');
    }

    /**
     * Exclui movimentação.
     */
    public function destroy(Movimentacao $movimentaco)
    {
        $tipo = $movimentaco->tipo;
        $movimentaco->delete();

        return redirect()
            ->route('professor.movimentacoes.index', ['tipo' => $tipo])
            ->with('success', 'Movimentação excluída.');
    }

    /**
     * Marca a movimentação como paga (ação rápida).
     */
    public function marcarPago(Movimentacao $movimentaco)
    {
        $movimentaco->update([
            'status'         => Movimentacao::STATUS_PAGO,
            'data_pagamento' => Carbon::today(),
        ]);

        return back()->with('success', 'Movimentação marcada como paga.');
    }

    /**
     * Validação compartilhada por create/update.
     */
    private function validarMovimentacao(Request $request): array
    {
        $dados = $request->validate([
            'tipo'            => ['required', 'in:entrada,saida'],
            'user_id'         => ['nullable', 'exists:users,id'],
            'descricao'       => ['required', 'string', 'max:255'],
            'valor'           => ['required', 'numeric', 'min:0'],
            'status'          => ['required', 'in:aberto,atraso,pago'],
            'data_vencimento' => ['required', 'date'],
            'data_pagamento'  => ['nullable', 'date'],
            'observacoes'     => ['nullable', 'string', 'max:1000'],
        ]);

        // Apenas entradas podem ter user_id
        if ($dados['tipo'] !== Movimentacao::TIPO_ENTRADA) {
            $dados['user_id'] = null;
        }

        // Se marcado como pago e não tem data de pagamento, preenche com hoje
        if ($dados['status'] === Movimentacao::STATUS_PAGO && empty($dados['data_pagamento'])) {
            $dados['data_pagamento'] = Carbon::today();
        }
        // Se não está pago, zera data de pagamento
        if ($dados['status'] !== Movimentacao::STATUS_PAGO) {
            $dados['data_pagamento'] = null;
        }

        return $dados;
    }

    /**
     * Atualiza para "atraso" todas as movimentações em aberto cuja data já passou.
     */
    private function recalcularAtrasos(): void
    {
        Movimentacao::where('status', Movimentacao::STATUS_ABERTO)
            ->whereDate('data_vencimento', '<', Carbon::today())
            ->update(['status' => Movimentacao::STATUS_ATRASO]);
    }

    /**
     * Helper estático usado por outros controllers para registrar uma entrada
     * a partir do pacote de aulas de um aluno (aprovação ou reativação).
     */
    public static function registrarEntradaPacote(User $aluno, int $aulasContratadas, float $valorAula, ?string $origem = null): Movimentacao
    {
        $total     = round($aulasContratadas * $valorAula, 2);
        $descricao = "Pacote {$aulasContratadas} aula(s) — {$aluno->name}";
        $obs       = "Referente a {$aulasContratadas} aula(s) × R$ "
            . number_format($valorAula, 2, ',', '.')
            . " = R$ " . number_format($total, 2, ',', '.');
        if ($origem) {
            $obs .= " (origem: {$origem})";
        }

        return Movimentacao::create([
            'tipo'            => Movimentacao::TIPO_ENTRADA,
            'user_id'         => $aluno->id,
            'descricao'       => $descricao,
            'valor'           => $total,
            'status'          => Movimentacao::STATUS_ABERTO,
            'data_vencimento' => Carbon::today(),
            'observacoes'     => $obs,
        ]);
    }
}
