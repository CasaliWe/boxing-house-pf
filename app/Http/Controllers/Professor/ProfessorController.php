<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class ProfessorController extends Controller
{
    /**
     * Exibe o formulário de edição dos dados do professor.
     */
    public function edit()
    {
        $professor = Auth::user();
        
        return view('professor.professor.edit', compact('professor'));
    }

    /**
     * Atualiza os dados do professor.
     */
    public function update(Request $request)
    {
        $professor = Auth::user();
        
        $dados = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'anos_boxe' => ['required', 'integer', 'min:0', 'max:50'],
            'anos_instrutor' => ['required', 'integer', 'min:0', 'max:50'],
            'descricao_professor' => ['required', 'string', 'max:1000'],
            'novas_imagens.*' => ['nullable', File::image()->max(5120)], // 5MB máximo por imagem
        ], [
            'name.required' => 'O nome é obrigatório.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'anos_boxe.required' => 'Os anos no boxe são obrigatórios.',
            'anos_boxe.integer' => 'Os anos no boxe deve ser um número inteiro.',
            'anos_boxe.min' => 'Os anos no boxe deve ser no mínimo 0.',
            'anos_boxe.max' => 'Os anos no boxe deve ser no máximo 50.',
            'anos_instrutor.required' => 'Os anos como instrutor são obrigatórios.',
            'anos_instrutor.integer' => 'Os anos como instrutor deve ser um número inteiro.',
            'anos_instrutor.min' => 'Os anos como instrutor deve ser no mínimo 0.',
            'anos_instrutor.max' => 'Os anos como instrutor deve ser no máximo 50.',
            'descricao_professor.required' => 'A descrição é obrigatória.',
            'descricao_professor.max' => 'A descrição não pode ter mais de 1000 caracteres.',
            'novas_imagens.*.image' => 'O arquivo deve ser uma imagem.',
            'novas_imagens.*.max' => 'Cada imagem deve ter no máximo 5MB.',
        ]);

        // Processar imagens atuais
        $imagensAtuais = json_decode($professor->imagens_professor ?? '[]', true);
        
        // Adicionar novas imagens
        if ($request->hasFile('novas_imagens')) {
            foreach ($request->file('novas_imagens') as $imagem) {
                if (count($imagensAtuais) < 5) {
                    $nomeArquivo = 'professor-' . $professor->id . '-' . time() . '-' . uniqid() . '.' . $imagem->getClientOriginalExtension();
                    $caminho = $imagem->storeAs('professor/imagens', $nomeArquivo, 'public');
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

        // Atualizar dados do professor
        $professor->update([
            'name' => $dados['name'],
            'anos_boxe' => $dados['anos_boxe'],
            'anos_instrutor' => $dados['anos_instrutor'],
            'descricao_professor' => $dados['descricao_professor'],
            'imagens_professor' => json_encode($imagensAtuais),
        ]);

        return redirect()
            ->route('professor.professor.edit')
            ->with('success', 'Dados do professor atualizados com sucesso!');
    }

    /**
     * Remove uma imagem específica do professor.
     */
    public function removerImagem(Request $request)
    {
        $professor = Auth::user();
        $indice = $request->input('indice');
        
        $imagensAtuais = json_decode($professor->imagens_professor ?? '[]', true);
        
        if (isset($imagensAtuais[$indice])) {
            // Deletar arquivo físico
            Storage::disk('public')->delete($imagensAtuais[$indice]);
            // Remover do array
            unset($imagensAtuais[$indice]);
            // Reindexar o array
            $imagensAtuais = array_values($imagensAtuais);
            
            // Atualizar no banco
            $professor->update([
                'imagens_professor' => json_encode($imagensAtuais),
            ]);
            
            return response()->json(['success' => true, 'message' => 'Imagem removida com sucesso!']);
        }
        
        return response()->json(['success' => false, 'message' => 'Imagem não encontrada.']);
    }
}
