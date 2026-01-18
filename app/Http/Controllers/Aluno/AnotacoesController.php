<?php

namespace App\Http\Controllers\Aluno;

use App\Http\Controllers\Controller;
use App\Models\Anotacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnotacoesController extends Controller
{
    /**
     * Lista todas as anotações do aluno logado
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = $user->anotacoes()->orderBy('data_anotacao', 'desc');
        
        // Filtro por data se informado
        if ($request->filled('data_filtro')) {
            $query->whereDate('data_anotacao', $request->data_filtro);
        }
        
        $anotacoes = $query->paginate(10);
        
        return view('aluno.anotacoes.index', compact('anotacoes'));
    }

    /**
     * Armazena uma nova anotação
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'conteudo' => 'required|string',
            'data_anotacao' => 'required|date',
        ], [
            'titulo.required' => 'O título é obrigatório',
            'titulo.max' => 'O título deve ter no máximo 255 caracteres',
            'conteudo.required' => 'O conteúdo é obrigatório',
            'data_anotacao.required' => 'A data é obrigatória',
            'data_anotacao.date' => 'Informe uma data válida',
        ]);

        Auth::user()->anotacoes()->create([
            'titulo' => $request->titulo,
            'conteudo' => $request->conteudo,
            'data_anotacao' => $request->data_anotacao,
        ]);

        return redirect()->route('aluno.anotacoes.index')->with('success', 'Anotação criada com sucesso!');
    }

    /**
     * Atualiza uma anotação existente
     */
    public function update(Request $request, Anotacao $anotacao)
    {
        // Verificar se a anotação pertence ao usuário logado
        if ($anotacao->user_id !== Auth::id()) {
            abort(403, 'Acesso negado');
        }

        $request->validate([
            'titulo' => 'required|string|max:255',
            'conteudo' => 'required|string',
            'data_anotacao' => 'required|date',
        ], [
            'titulo.required' => 'O título é obrigatório',
            'titulo.max' => 'O título deve ter no máximo 255 caracteres',
            'conteudo.required' => 'O conteúdo é obrigatório',
            'data_anotacao.required' => 'A data é obrigatória',
            'data_anotacao.date' => 'Informe uma data válida',
        ]);

        $anotacao->update([
            'titulo' => $request->titulo,
            'conteudo' => $request->conteudo,
            'data_anotacao' => $request->data_anotacao,
        ]);

        return redirect()->route('aluno.anotacoes.index')->with('success', 'Anotação atualizada com sucesso!');
    }

    /**
     * Remove uma anotação
     */
    public function destroy(Anotacao $anotacao)
    {
        // Verificar se a anotação pertence ao usuário logado
        if ($anotacao->user_id !== Auth::id()) {
            abort(403, 'Acesso negado');
        }

        $anotacao->delete();

        return redirect()->route('aluno.anotacoes.index')->with('success', 'Anotação excluída com sucesso!');
    }
}