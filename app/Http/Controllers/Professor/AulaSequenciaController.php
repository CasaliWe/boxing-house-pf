<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\AulaSequencia;
use Illuminate\Http\Request;

class AulaSequenciaController extends Controller
{
    /**
     * Lista sequências.
     */
    public function index()
    {
        $sequencias = AulaSequencia::orderBy('numero')->paginate(20);
        return view('professor.aulas.index', compact('sequencias'));
    }

    /**
     * Form criar.
     */
    public function create()
    {
        return view('professor.aulas.create');
    }

    /**
     * Salvar nova sequência.
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'numero' => ['required', 'integer', 'min:1', 'unique:aula_sequencias,numero'],
            'descricao' => ['required', 'string'],
            'ativo' => ['nullable', 'boolean'],
        ]);

        AulaSequencia::create([
            'numero' => $dados['numero'],
            'descricao' => $dados['descricao'],
            'ativo' => (bool)($dados['ativo'] ?? true),
        ]);

        return redirect()->route('professor.aulas-sequencia.index')
            ->with('success', 'Sequência criada com sucesso.');
    }

    /**
     * Form editar.
     */
    public function edit(AulaSequencia $sequencia)
    {
        return view('professor.aulas.edit', compact('sequencia'));
    }

    /**
     * Atualizar.
     */
    public function update(Request $request, AulaSequencia $sequencia)
    {
        $dados = $request->validate([
            'numero' => ['required', 'integer', 'min:1', 'unique:aula_sequencias,numero,' . $sequencia->id],
            'descricao' => ['required', 'string'],
            'ativo' => ['nullable', 'boolean'],
        ]);

        $sequencia->update([
            'numero' => $dados['numero'],
            'descricao' => $dados['descricao'],
            'ativo' => (bool)($dados['ativo'] ?? true),
        ]);

        return redirect()->route('professor.aulas-sequencia.index')
            ->with('success', 'Sequência atualizada com sucesso.');
    }

    /**
     * Excluir.
     */
    public function destroy(AulaSequencia $sequencia)
    {
        $sequencia->delete();
        return redirect()->route('professor.aulas-sequencia.index')
            ->with('success', 'Sequência excluída com sucesso.');
    }
}
