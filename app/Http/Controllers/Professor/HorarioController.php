<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Horario;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HorarioController extends Controller
{
    /**
     * Lista horários com contagem e nomes de alunos aprovados.
     */
    public function index()
    {
        $horarios = Horario::with(['alunos' => function ($q) {
                $q->wherePivot('aprovado', true)->orderBy('name');
            }])
            ->withCount(['alunos as alunos_aprovados_count' => function ($q) {
                $q->wherePivot('aprovado', true);
            }])
            ->orderBy('dia_semana')
            ->orderBy('hora_inicio')
            ->get();

        return view('professor.horarios.index', compact('horarios'))
            ->with('title', 'Horários');
    }

    /**
     * Formulário de criação.
     */
    public function create()
    {
        return view('professor.horarios.create');
    }

    /**
     * Salva novo horário.
     */
    public function store(Request $request)
    {
        $dados = $this->validar($request);

        Horario::create($dados);

        return redirect()->route('professor.horarios.index')
            ->with('success', 'Horário criado com sucesso.');
    }

    /**
     * Formulário de edição.
     */
    public function edit(Horario $horario)
    {
        return view('professor.horarios.edit', compact('horario'));
    }

    /**
     * Atualiza horário.
     */
    public function update(Request $request, Horario $horario)
    {
        $dados = $this->validar($request, $horario->id);
        $horario->update($dados);

        return redirect()->route('professor.horarios.index')
            ->with('success', 'Horário atualizado com sucesso.');
    }

    /**
     * Remove horário.
     */
    public function destroy(Horario $horario)
    {
        $horario->delete();
        return redirect()->route('professor.horarios.index')
            ->with('success', 'Horário removido com sucesso.');
    }

    /**
     * Validação comum de criar/atualizar.
     */
    protected function validar(Request $request, ?int $idIgnorar = null): array
    {
        $rules = [
            'dia_semana'   => ['required', 'integer', 'between:1,7'],
            // Aceita input de <input type="time"> (HH:MM)
            'hora_inicio'  => ['required', 'date_format:H:i'],
            'hora_fim'     => ['required', 'date_format:H:i', 'after:hora_inicio'],
        ];

        // Normaliza para HH:MM:SS para comparar com o banco e manter consistência
        $inicioNormalizado = $this->normalizarHora($request->input('hora_inicio'));
        $fimNormalizado    = $this->normalizarHora($request->input('hora_fim'));

        // Unicidade por dia + início + fim, comparando usando os valores normalizados
        $rules['dia_semana'][] = Rule::unique('horarios', 'dia_semana')
            ->where(fn ($q) => $q->where('hora_inicio', $inicioNormalizado)
                                  ->where('hora_fim', $fimNormalizado))
            ->ignore($idIgnorar);

        $mensagens = [
            'dia_semana.required' => 'Selecione o dia da semana.',
            'dia_semana.between'  => 'Dia da semana inválido.',
            'hora_inicio.required'=> 'Informe a hora de início.',
            'hora_inicio.date_format'=> 'Formato da hora de início inválido (HH:MM).',
            'hora_fim.required'   => 'Informe a hora de fim.',
            'hora_fim.after'      => 'A hora de fim deve ser após a hora de início.',
            'hora_fim.date_format'=> 'Formato da hora de fim inválido (HH:MM).',
            'dia_semana.unique'   => 'Já existe um horário com este dia e intervalo.',
        ];

        $dados = $request->validate($rules, $mensagens);
        // Após validar, normaliza para persistir sempre em HH:MM:SS
        $dados['hora_inicio'] = $this->normalizarHora($dados['hora_inicio']);
        $dados['hora_fim']    = $this->normalizarHora($dados['hora_fim']);
        return $dados;
    }

    /**
     * Converte "HH:MM" ou "HH:MM:SS" para "HH:MM:SS" de forma segura.
     */
    private function normalizarHora(string $valor): string
    {
        try {
            return \Illuminate\Support\Carbon::parse($valor)->format('H:i:s');
        } catch (\Throwable $e) {
            return $valor; // fallback (não deve ocorrer com input <time>)
        }
    }
}
