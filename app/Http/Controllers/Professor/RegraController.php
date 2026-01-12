<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Regra;
use Illuminate\Http\Request;

class RegraController extends Controller
{
    /**
     * Lista regras e aceites, ordenadas por 'ordem' e criação.
     */
    public function index()
    {
        $regras = Regra::orderByRaw('COALESCE(ordem, 99999) ASC')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('professor.regras.index', compact('regras'));
    }

    /**
     * Formulário de criação.
     */
    public function create()
    {
        return view('professor.regras.create');
    }

    /**
     * Armazenar nova regra.
     */
    public function store(Request $request)
    {
        $dados = $this->validar($request);
        Regra::create($dados);
        return redirect()->route('professor.regras.index')->with('success', 'Regra/aceite criado com sucesso.');
    }

    /**
     * Formulário de edição.
     */
    public function edit(Regra $regra)
    {
        return view('professor.regras.edit', compact('regra'));
    }

    /**
     * Atualizar regra.
     */
    public function update(Request $request, Regra $regra)
    {
        $dados = $this->validar($request);
        $regra->update($dados);
        return redirect()->route('professor.regras.index')->with('success', 'Regra/aceite atualizado com sucesso.');
    }

    /**
     * Remover regra.
     */
    public function destroy(Regra $regra)
    {
        $regra->delete();
        return redirect()->route('professor.regras.index')->with('success', 'Regra/aceite removido com sucesso.');
    }

    /**
     * Validação comum.
     */
    protected function validar(Request $request): array
    {
        $dados = $request->validate([
            'titulo'   => ['required', 'string', 'max:120'],
            'conteudo' => ['required', 'string'],
            'ativo'    => ['nullable', 'boolean'],
            'ordem'    => ['nullable', 'integer', 'min:0'],
        ], [
            'titulo.required' => 'Informe um título para a regra/aceite.',
            'conteudo.required' => 'Informe o conteúdo da regra/aceite.',
        ]);

        $dados['ativo'] = (bool) ($dados['ativo'] ?? false);
        return $dados;
    }
}
