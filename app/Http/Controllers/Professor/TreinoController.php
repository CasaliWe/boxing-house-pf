<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Treino;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TreinoController extends Controller
{
    /**
     * Lista treinos.
     */
    public function index()
    {
        $treinos = Treino::withCount('alunos')->orderByDesc('data')->paginate(12);
        return view('professor.treinos.index', compact('treinos'));
    }

    /**
     * Form criar.
     */
    public function create()
    {
        $alunos = User::query()
            ->where('role', 'aluno')
            ->where('status', 'ativo')
            ->orderBy('name')
            ->get();
        return view('professor.treinos.create', compact('alunos'));
    }

    /**
     * Salvar novo treino.
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'data' => ['required', 'date'],
            'foto' => ['required', 'image', 'max:4096'],
            'especial' => ['nullable', 'boolean'],
            'alunos' => ['nullable', 'array'],
            'alunos.*' => ['exists:users,id'],
        ]);

        $path = $request->file('foto')->store('treinos', 'public');

        $treino = Treino::create([
            'data' => $dados['data'],
            'foto_path' => $path,
            'especial' => (bool)($dados['especial'] ?? false),
        ]);

        $treino->alunos()->sync($dados['alunos'] ?? []);

        return redirect()->route('professor.treinos.index')
            ->with('success', 'Treino criado com sucesso.');
    }

    /**
     * Visualizar treino.
     */
    public function show(Treino $treino)
    {
        $treino->load('alunos');
        return view('professor.treinos.show', compact('treino'));
    }

    /**
     * Form editar.
     */
    public function edit(Treino $treino)
    {
        $alunos = User::query()
            ->where('role', 'aluno')
            ->where('status', 'ativo')
            ->orderBy('name')
            ->get();
        $treino->load('alunos');
        return view('professor.treinos.edit', compact('treino', 'alunos'));
    }

    /**
     * Atualizar treino.
     */
    public function update(Request $request, Treino $treino)
    {
        $dados = $request->validate([
            'data' => ['required', 'date'],
            'foto' => ['nullable', 'image', 'max:4096'],
            'especial' => ['nullable', 'boolean'],
            'alunos' => ['nullable', 'array'],
            'alunos.*' => ['exists:users,id'],
        ]);

        $update = [
            'data' => $dados['data'],
            'especial' => (bool)($dados['especial'] ?? false),
        ];

        if ($request->hasFile('foto')) {
            // Apagar foto antiga e salvar nova
            if ($treino->foto_path) {
                $caminhoAntigo = public_path($treino->foto_path);
                if (file_exists($caminhoAntigo)) {
                    unlink($caminhoAntigo);
                }
            }
            
            $arquivo = $request->file('foto');
            $nomeArquivo = 'treino-' . time() . '-' . uniqid() . '.' . $arquivo->getClientOriginalExtension();
            
            // Criar diretório se não existir
            $diretorio = public_path('uploads/treinos');
            if (!file_exists($diretorio)) {
                mkdir($diretorio, 0755, true);
            }
            
            // Mover arquivo para public
            $arquivo->move($diretorio, $nomeArquivo);
            $update['foto_path'] = 'uploads/treinos/' . $nomeArquivo;
        }

        $treino->update($update);
        $treino->alunos()->sync($dados['alunos'] ?? []);

        return redirect()->route('professor.treinos.index')
            ->with('success', 'Treino atualizado com sucesso.');
    }

    /**
     * Excluir treino.
     */
    public function destroy(Treino $treino)
    {
        // Remove foto
        if ($treino->foto_path) {
            $caminhoArquivo = public_path($treino->foto_path);
            if (file_exists($caminhoArquivo)) {
                unlink($caminhoArquivo);
            }
        }

        $treino->delete();
        return redirect()->route('professor.treinos.index')
            ->with('success', 'Treino excluído com sucesso.');
    }
}
