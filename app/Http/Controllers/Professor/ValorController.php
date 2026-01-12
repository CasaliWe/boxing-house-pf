<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\ValorPlano;
use Illuminate\Http\Request;

class ValorController extends Controller
{
    /**
     * Lista valores cadastrados.
     */
    public function index()
    {
        $valores = ValorPlano::orderBy('vezes_semana')->get();
        return view('professor.valores.index', compact('valores'));
    }

    /**
     * Formulário de criação.
     */
    public function create()
    {
        return view('professor.valores.create');
    }

    /**
     * Armazenar novo valor.
     */
    public function store(Request $request)
    {
        $dados = $this->validar($request);
        ValorPlano::create($dados);
        return redirect()->route('professor.valores.index')->with('success', 'Valor criado com sucesso.');
    }

    /**
     * Formulário de edição.
     */
    public function edit(ValorPlano $valore)
    {
        // Nota: route model binding usa o nome singular do recurso
        return view('professor.valores.edit', ['valor' => $valore]);
    }

    /**
     * Atualizar valor.
     */
    public function update(Request $request, ValorPlano $valore)
    {
        $dados = $this->validar($request, $valore->id);
        $valore->update($dados);
        return redirect()->route('professor.valores.index')->with('success', 'Valor atualizado com sucesso.');
    }

    /**
     * Remover valor.
     */
    public function destroy(ValorPlano $valore)
    {
        $valore->delete();
        return redirect()->route('professor.valores.index')->with('success', 'Valor removido com sucesso.');
    }

    /**
     * Validação comum.
     */
    protected function validar(Request $request, ?int $ignorarId = null): array
    {
        $dados = $request->validate([
            'vezes_semana' => ['required', 'integer', 'between:1,5', 'unique:valores,vezes_semana,' . ($ignorarId ?? 'NULL')],
            'valor' => ['required', 'numeric', 'min:0'],
        ], [
            'vezes_semana.required' => 'Informe quantas vezes por semana (1 a 5).',
            'vezes_semana.between' => 'O número de vezes por semana deve estar entre 1 e 5.',
            'vezes_semana.unique' => 'Já existe um valor cadastrado para esta quantidade semanal.',
            'valor.required' => 'Informe o valor.',
            'valor.numeric' => 'O valor deve ser numérico.',
        ]);

        // Normaliza casas decimais
        $dados['valor'] = number_format((float) $dados['valor'], 2, '.', '');
        return $dados;
    }
}
