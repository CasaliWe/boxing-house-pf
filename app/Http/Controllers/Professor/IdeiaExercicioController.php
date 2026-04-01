<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\IdeiaExercicio;
use Illuminate\Http\Request;

class IdeiaExercicioController extends Controller
{
    /**
     * Lista todas as ideias de exercícios.
     */
    public function index()
    {
        $ideias = IdeiaExercicio::orderBy('created_at', 'desc')->get();
        return view('professor.ideias-exercicios.index', compact('ideias'));
    }

    /**
     * Formulário de criação.
     */
    public function create()
    {
        return view('professor.ideias-exercicios.create');
    }

    /**
     * Salva nova ideia de exercício.
     */
    public function store(Request $request)
    {
        $dados = $this->validar($request);
        IdeiaExercicio::create($dados);

        return redirect()->route('professor.ideias-exercicios.index')
            ->with('success', 'Ideia de exercício criada com sucesso.');
    }

    /**
     * Formulário de edição.
     */
    public function edit(IdeiaExercicio $ideias_exercicio)
    {
        return view('professor.ideias-exercicios.edit', ['ideia' => $ideias_exercicio]);
    }

    /**
     * Atualiza ideia de exercício.
     */
    public function update(Request $request, IdeiaExercicio $ideias_exercicio)
    {
        $dados = $this->validar($request);
        $ideias_exercicio->update($dados);

        return redirect()->route('professor.ideias-exercicios.index')
            ->with('success', 'Ideia de exercício atualizada com sucesso.');
    }

    /**
     * Remove ideia de exercício.
     */
    public function destroy(IdeiaExercicio $ideias_exercicio)
    {
        $ideias_exercicio->delete();
        return redirect()->route('professor.ideias-exercicios.index')
            ->with('success', 'Ideia de exercício removida com sucesso.');
    }

    /**
     * Validação comum.
     */
    protected function validar(Request $request): array
    {
        return $request->validate([
            'nome'      => ['required', 'string', 'max:255'],
            'descricao' => ['required', 'string'],
            'video_url' => ['nullable', 'url', 'max:500'],
        ], [
            'nome.required'      => 'Informe o nome do exercício.',
            'descricao.required' => 'Informe a descrição do exercício.',
            'video_url.url'      => 'Informe uma URL válida para o vídeo.',
        ]);
    }
}
