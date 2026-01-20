<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\SistemaAluno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class AppController extends Controller
{
    /**
     * Exibe o formulário de configuração do sistema do aluno.
     */
    public function index()
    {
        $sistemaAluno = SistemaAluno::first() ?? new SistemaAluno([
            'titulo' => 'Sistema do Aluno',
            'descricao' => 'Acompanhe sua evolução, aulas participadas e mais — tudo em um só lugar.',
            'resumo_items' => [
                'Evolução real no seu ritmo',
                'Registro de aulas participadas', 
                'Acesso simples pela área do aluno'
            ],
            'detalhes' => 'Visualize sua participação nas aulas e o progresso ao longo do tempo. Tenha clareza sobre sua evolução técnica e física, com foco no que importa.',
            'imagens' => [],
            'ativo' => true
        ]);
        
        return view('professor.app.index', compact('sistemaAluno'));
    }

    /**
     * Atualiza os dados do sistema do aluno.
     */
    public function update(Request $request)
    {
        $dados = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'descricao' => ['nullable', 'string', 'max:500'],
            'detalhes' => ['required', 'string', 'max:1000'],
            'resumo_items' => ['required', 'array', 'min:1'],
            'resumo_items.*' => ['required', 'string', 'max:255'],
            'novas_imagens.*' => ['nullable', File::image()->max(5120)], // 5MB máximo por imagem
        ], [
            'titulo.required' => 'O título é obrigatório.',
            'titulo.max' => 'O título não pode ter mais de 255 caracteres.',
            'descricao.max' => 'A descrição não pode ter mais de 500 caracteres.',
            'detalhes.required' => 'Os detalhes são obrigatórios.',
            'detalhes.max' => 'Os detalhes não podem ter mais de 1000 caracteres.',
            'resumo_items.required' => 'Pelo menos um item do resumo é obrigatório.',
            'resumo_items.*.required' => 'O item do resumo não pode estar vazio.',
            'resumo_items.*.max' => 'Cada item do resumo não pode ter mais de 255 caracteres.',
            'novas_imagens.*.image' => 'O arquivo deve ser uma imagem.',
            'novas_imagens.*.max' => 'Cada imagem deve ter no máximo 5MB.',
        ]);

        $sistemaAluno = SistemaAluno::first();
        
        if (!$sistemaAluno) {
            $sistemaAluno = new SistemaAluno();
        }

        // Processar imagens atuais
        $imagensAtuais = $sistemaAluno->imagens ?? [];
        
        // Adicionar novas imagens
        if ($request->hasFile('novas_imagens')) {
            foreach ($request->file('novas_imagens') as $imagem) {
                if (count($imagensAtuais) < 10) { // Limite de 10 imagens
                    $nomeArquivo = 'sistema-aluno-' . time() . '-' . uniqid() . '.' . $imagem->getClientOriginalExtension();
                    $caminho = $imagem->storeAs('sistema-aluno/imagens', $nomeArquivo, 'public');
                    $imagensAtuais[] = $caminho;
                }
            }
        }

        // Remover imagens marcadas para exclusão
        if ($request->has('remover_imagens')) {
            $imagensParaRemover = $request->input('remover_imagens', []);
            foreach ($imagensParaRemover as $indice) {
                if (isset($imagensAtuais[$indice])) {
                    // Deletar arquivo físico
                    Storage::disk('public')->delete($imagensAtuais[$indice]);
                    // Remover do array
                    unset($imagensAtuais[$indice]);
                }
            }
            // Reindexar o array
            $imagensAtuais = array_values($imagensAtuais);
        }

        // Atualizar dados
        $sistemaAluno->fill([
            'titulo' => $dados['titulo'],
            'descricao' => $dados['descricao'],
            'detalhes' => $dados['detalhes'],
            'resumo_items' => $dados['resumo_items'],
            'imagens' => $imagensAtuais,
            'ativo' => true
        ]);

        $sistemaAluno->save();

        return redirect()
            ->route('professor.app.index')
            ->with('success', 'Configurações do sistema atualizadas com sucesso!');
    }

    /**
     * Remove uma imagem específica do sistema.
     */
    public function removerImagem(Request $request)
    {
        $request->validate([
            'indice' => ['required', 'integer', 'min:0']
        ]);

        $sistemaAluno = SistemaAluno::first();
        
        if (!$sistemaAluno) {
            return response()->json(['success' => false, 'message' => 'Sistema não encontrado.']);
        }

        $imagens = $sistemaAluno->imagens ?? [];
        $indice = $request->input('indice');

        if (!isset($imagens[$indice])) {
            return response()->json(['success' => false, 'message' => 'Imagem não encontrada.']);
        }

        // Deletar arquivo físico
        Storage::disk('public')->delete($imagens[$indice]);

        // Remover do array e reindexar
        unset($imagens[$indice]);
        $imagens = array_values($imagens);

        // Atualizar no banco
        $sistemaAluno->update(['imagens' => $imagens]);

        return response()->json(['success' => true, 'message' => 'Imagem removida com sucesso.']);
    }
}