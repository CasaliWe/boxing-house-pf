<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\ValorPlano;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class ValorController extends Controller
{
    /**
     * Lista valores cadastrados.
     */
    public function index()
    {
        $pacotes = ValorPlano::pacotes()->orderBy('aulas_mes')->get();
        $experimental = ValorPlano::experimental()->first();

        return view('professor.valores.index', compact('pacotes', 'experimental'));
    }

    /**
     * Formulario de criacao.
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
     * Formulario de edicao.
     */
    public function edit(ValorPlano $valore)
    {
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
     * Validacao comum.
     */
    protected function validar(Request $request, ?int $ignorarId = null): array
    {
        $dados = $request->validate([
            'tipo' => ['required', Rule::in([ValorPlano::TIPO_PACOTE, ValorPlano::TIPO_EXPERIMENTAL])],
            'aulas_mes' => ['nullable', 'required_if:tipo,' . ValorPlano::TIPO_PACOTE, 'integer', 'min:1', 'max:100'],
            'valor_aula' => ['required', 'numeric', 'min:0'],
        ], [
            'tipo.required' => 'Selecione o tipo de valor.',
            'tipo.in' => 'Tipo de valor invalido.',
            'aulas_mes.required_if' => 'Informe ate quantas aulas este pacote cobre.',
            'aulas_mes.integer' => 'A quantidade de aulas deve ser um numero inteiro.',
            'valor_aula.required' => 'Informe o valor por aula.',
            'valor_aula.numeric' => 'O valor por aula deve ser numerico.',
        ]);

        if ($dados['tipo'] === ValorPlano::TIPO_PACOTE) {
            $existePacote = ValorPlano::pacotes()
                ->where('aulas_mes', (int) $dados['aulas_mes'])
                ->when($ignorarId, fn ($query) => $query->where('id', '!=', $ignorarId))
                ->exists();

            if ($existePacote) {
                throw ValidationException::withMessages([
                    'aulas_mes' => 'Ja existe um pacote cadastrado para esta quantidade de aulas.',
                ]);
            }
        }

        if ($dados['tipo'] === ValorPlano::TIPO_EXPERIMENTAL) {
            $existeExperimental = ValorPlano::experimental()
                ->when($ignorarId, fn ($query) => $query->where('id', '!=', $ignorarId))
                ->exists();

            if ($existeExperimental) {
                throw ValidationException::withMessages([
                    'tipo' => 'Ja existe um valor cadastrado para aula experimental.',
                ]);
            }
        }

        $aulasMes = $dados['tipo'] === ValorPlano::TIPO_PACOTE ? (int) $dados['aulas_mes'] : null;
        $valorAula = number_format((float) $dados['valor_aula'], 2, '.', '');

        return [
            'tipo' => $dados['tipo'],
            'aulas_mes' => $aulasMes,
            'valor_aula' => $valorAula,
            // Campos antigos mantidos para compatibilidade com banco/codigo legado.
            'vezes_semana' => $dados['tipo'] === ValorPlano::TIPO_PACOTE ? $aulasMes : 0,
            'valor' => $valorAula,
        ];
    }
}
