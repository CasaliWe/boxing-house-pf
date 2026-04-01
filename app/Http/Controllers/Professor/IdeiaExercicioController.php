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

        if ($request->hasFile('video')) {
            $arquivo = $request->file('video');
            $nome = time() . '_' . $arquivo->getClientOriginalName();
            $arquivo->move(public_path('uploads/ideias-exercicios'), $nome);
            $dados['video_path'] = 'uploads/ideias-exercicios/' . $nome;
        }

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

        if ($request->hasFile('video')) {
            // Remover vídeo antigo
            if ($ideias_exercicio->video_path && file_exists(public_path($ideias_exercicio->video_path))) {
                unlink(public_path($ideias_exercicio->video_path));
            }
            $arquivo = $request->file('video');
            $nome = time() . '_' . $arquivo->getClientOriginalName();
            $arquivo->move(public_path('uploads/ideias-exercicios'), $nome);
            $dados['video_path'] = 'uploads/ideias-exercicios/' . $nome;
        }

        $ideias_exercicio->update($dados);

        return redirect()->route('professor.ideias-exercicios.index')
            ->with('success', 'Ideia de exercício atualizada com sucesso.');
    }

    /**
     * Remove ideia de exercício.
     */
    public function destroy(IdeiaExercicio $ideias_exercicio)
    {
        if ($ideias_exercicio->video_path && file_exists(public_path($ideias_exercicio->video_path))) {
            unlink(public_path($ideias_exercicio->video_path));
        }
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
            'video'     => ['nullable', 'file', 'mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/webm', 'max:102400'],
        ], [
            'nome.required'      => 'Informe o nome do exercício.',
            'descricao.required' => 'Informe a descrição do exercício.',
            'video.mimetypes'    => 'O arquivo deve ser um vídeo (MP4, MOV, AVI ou WebM).',
            'video.max'          => 'O vídeo pode ter no máximo 100MB.',
        ]);
    }
}
