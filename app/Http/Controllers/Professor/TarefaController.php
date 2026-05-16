<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Tarefa;
use Illuminate\Http\Request;

class TarefaController extends Controller
{
    /**
     * Lista as tarefas agrupadas por status, com a aba ativa filtrada.
     */
    public function index(Request $request)
    {
        $aba = $request->get('aba', Tarefa::STATUS_FAZER);
        if (!in_array($aba, Tarefa::ORDEM, true)) {
            $aba = Tarefa::STATUS_FAZER;
        }

        $tarefas = Tarefa::where('status', $aba)->orderByDesc('updated_at')->get();

        // Totais por status para as abas
        $totais = [
            Tarefa::STATUS_FAZER   => Tarefa::where('status', Tarefa::STATUS_FAZER)->count(),
            Tarefa::STATUS_FAZENDO => Tarefa::where('status', Tarefa::STATUS_FAZENDO)->count(),
            Tarefa::STATUS_FEITO   => Tarefa::where('status', Tarefa::STATUS_FEITO)->count(),
        ];

        return view('professor.tarefas.index', compact('tarefas', 'aba', 'totais'));
    }

    /**
     * Cria nova tarefa (sempre no estado "fazer").
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'titulo'    => ['required', 'string', 'max:255'],
            'descricao' => ['nullable', 'string', 'max:1000'],
        ]);

        Tarefa::create([
            'titulo'    => $dados['titulo'],
            'descricao' => $dados['descricao'] ?? null,
            'status'    => Tarefa::STATUS_FAZER,
        ]);

        return back()->with('success', 'Tarefa criada.');
    }

    /**
     * Atualiza título / descrição.
     */
    public function update(Request $request, Tarefa $tarefa)
    {
        $dados = $request->validate([
            'titulo'    => ['required', 'string', 'max:255'],
            'descricao' => ['nullable', 'string', 'max:1000'],
        ]);
        $tarefa->update($dados);

        return back()->with('success', 'Tarefa atualizada.');
    }

    /**
     * Move a tarefa para o próximo estado.
     */
    public function avancar(Tarefa $tarefa)
    {
        $proximo = $tarefa->proximoStatus();
        if ($proximo) {
            $tarefa->update(['status' => $proximo]);
        }
        return back();
    }

    /**
     * Volta a tarefa para o estado anterior.
     */
    public function retroceder(Tarefa $tarefa)
    {
        $anterior = $tarefa->statusAnterior();
        if ($anterior) {
            $tarefa->update(['status' => $anterior]);
        }
        return back();
    }

    /**
     * Exclui a tarefa.
     */
    public function destroy(Tarefa $tarefa)
    {
        $tarefa->delete();
        return back()->with('success', 'Tarefa excluída.');
    }
}
