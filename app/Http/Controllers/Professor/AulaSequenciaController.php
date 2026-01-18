<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\AulaSequencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'video' => ['nullable', 'file', 'mimetypes:video/*'],
            'ativo' => ['nullable', 'boolean'],
        ]);
        $videoPath = null;
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('sequencias', 'public');
        }

        AulaSequencia::create([
            'numero' => $dados['numero'],
            'descricao' => $dados['descricao'],
            'video_path' => $videoPath,
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
            'video' => ['nullable', 'file', 'mimetypes:video/*'],
            'ativo' => ['nullable', 'boolean'],
        ]);
        $update = [
            'numero' => $dados['numero'],
            'descricao' => $dados['descricao'],
            'ativo' => (bool)($dados['ativo'] ?? true),
        ];

        if ($request->hasFile('video')) {
            if ($sequencia->video_path && Storage::disk('public')->exists($sequencia->video_path)) {
                Storage::disk('public')->delete($sequencia->video_path);
            }
            $update['video_path'] = $request->file('video')->store('sequencias', 'public');
        }

        $sequencia->update($update);

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
