<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\AulaExp;
use Illuminate\Http\Request;

class AulaExpController extends Controller
{
    /**
     * Lista todas as aulas experimentais.
     */
    public function index()
    {
        $aulas = AulaExp::orderBy('data', 'desc')->orderBy('horario', 'desc')->get();
        return view('professor.aulas-exp.index', compact('aulas'));
    }

    /**
     * Formulário de criação.
     */
    public function create()
    {
        return view('professor.aulas-exp.create');
    }

    /**
     * Salva nova aula experimental.
     */
    public function store(Request $request)
    {
        $dados = $this->validar($request);
        AulaExp::create($dados);

        return redirect()->route('professor.aulas-exp.index')
            ->with('success', 'Aula EXP criada com sucesso.');
    }

    /**
     * Formulário de edição.
     */
    public function edit(AulaExp $aula_exp)
    {
        return view('professor.aulas-exp.edit', ['aula' => $aula_exp]);
    }

    /**
     * Atualiza aula experimental.
     */
    public function update(Request $request, AulaExp $aula_exp)
    {
        $dados = $this->validar($request);
        $aula_exp->update($dados);

        return redirect()->route('professor.aulas-exp.index')
            ->with('success', 'Aula EXP atualizada com sucesso.');
    }

    /**
     * Remove aula experimental.
     */
    public function destroy(AulaExp $aula_exp)
    {
        $aula_exp->delete();
        return redirect()->route('professor.aulas-exp.index')
            ->with('success', 'Aula EXP removida com sucesso.');
    }

    /**
     * Validação comum.
     */
    protected function validar(Request $request): array
    {
        return $request->validate([
            'nome'        => ['required', 'string', 'max:255'],
            'data'        => ['required', 'date'],
            'dia_semana'  => ['required', 'integer', 'between:1,7'],
            'horario'     => ['required', 'date_format:H:i'],
            'numero'      => ['nullable', 'string', 'max:255'],
            'observacao'  => ['nullable', 'string'],
        ], [
            'nome.required'       => 'Informe o nome da pessoa.',
            'data.required'       => 'Informe a data da aula.',
            'dia_semana.required' => 'Selecione o dia da semana.',
            'horario.required'    => 'Informe o horário da aula.',
        ]);
    }
}
