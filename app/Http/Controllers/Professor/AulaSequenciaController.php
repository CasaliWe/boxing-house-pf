<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\AulaSequencia;
use Illuminate\Http\Request;

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
            'imagem' => ['nullable', 'file', 'image', 'max:5120'], // 5MB máximo
            'ativo' => ['nullable', 'boolean'],
        ]);
        
        $imagemPath = null;
        if ($request->hasFile('imagem')) {
            $arquivo = $request->file('imagem');
            $nomeArquivo = 'sequencia-' . time() . '-' . uniqid() . '.' . $arquivo->getClientOriginalExtension();
            
            // Criar diretório se não existir
            $diretorio = public_path('uploads/sequencias');
            if (!file_exists($diretorio)) {
                mkdir($diretorio, 0755, true);
            }
            
            // Mover arquivo para public
            $arquivo->move($diretorio, $nomeArquivo);
            $imagemPath = 'uploads/sequencias/' . $nomeArquivo;
        }

        AulaSequencia::create([
            'numero' => $dados['numero'],
            'descricao' => $dados['descricao'],
            'video_path' => $imagemPath, // Mantendo o campo video_path por compatibilidade
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
            'imagem' => ['nullable', 'file', 'image', 'max:5120'], // 5MB máximo
            'ativo' => ['nullable', 'boolean'],
        ]);
        
        $update = [
            'numero' => $dados['numero'],
            'descricao' => $dados['descricao'],
            'ativo' => (bool)($dados['ativo'] ?? true),
        ];

        if ($request->hasFile('imagem')) {
            // Remover imagem antiga se existir
            if ($sequencia->video_path) {
                $caminhoAntigo = public_path($sequencia->video_path);
                if (file_exists($caminhoAntigo)) {
                    unlink($caminhoAntigo);
                }
            }
            
            $arquivo = $request->file('imagem');
            $nomeArquivo = 'sequencia-' . time() . '-' . uniqid() . '.' . $arquivo->getClientOriginalExtension();
            
            // Criar diretório se não existir
            $diretorio = public_path('uploads/sequencias');
            if (!file_exists($diretorio)) {
                mkdir($diretorio, 0755, true);
            }
            
            // Mover arquivo para public
            $arquivo->move($diretorio, $nomeArquivo);
            $update['video_path'] = 'uploads/sequencias/' . $nomeArquivo; // Mantendo campo video_path
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
        // Remover imagem se existir
        if ($sequencia->video_path) {
            $caminhoArquivo = public_path($sequencia->video_path);
            if (file_exists($caminhoArquivo)) {
                unlink($caminhoArquivo);
            }
        }
        
        $sequencia->delete();
        return redirect()->route('professor.aulas-sequencia.index')
            ->with('success', 'Sequência excluída com sucesso.');
    }
}
