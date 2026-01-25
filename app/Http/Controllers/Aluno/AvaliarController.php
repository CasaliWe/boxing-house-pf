<?php

namespace App\Http\Controllers\Aluno;

use App\Http\Controllers\Controller;
use App\Models\Avaliacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;

class AvaliarController extends Controller
{
    /**
     * Exibe o formulário de avaliação.
     */
    public function index()
    {
        $avaliacao = Avaliacao::where('user_id', Auth::id())->first();
        
        return view('aluno.avaliar.index', compact('avaliacao'));
    }

    /**
     * Salva ou atualiza a avaliação do aluno.
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'comentario' => ['required', 'string', 'min:10', 'max:500'],
            'foto_avaliacao' => ['nullable', File::image()->max(5120)], // 5MB máximo
            'exibir_landing' => ['boolean']
        ], [
            'comentario.required' => 'O comentário é obrigatório.',
            'comentario.min' => 'O comentário deve ter pelo menos 10 caracteres.',
            'comentario.max' => 'O comentário não pode ter mais de 500 caracteres.',
            'foto_avaliacao.image' => 'O arquivo deve ser uma imagem.',
            'foto_avaliacao.max' => 'A imagem deve ter no máximo 5MB.',
        ]);

        $avaliacao = Avaliacao::where('user_id', Auth::id())->first();
        
        if (!$avaliacao) {
            $avaliacao = new Avaliacao();
            $avaliacao->user_id = Auth::id();
        }

        // Processar foto
        if ($request->hasFile('foto_avaliacao')) {
            // Remover foto antiga se existir
            if ($avaliacao->foto_avaliacao) {
                $caminhoAntigo = public_path($avaliacao->foto_avaliacao);
                if (file_exists($caminhoAntigo)) {
                    unlink($caminhoAntigo);
                }
            }
            
            $arquivo = $request->file('foto_avaliacao');
            $nomeArquivo = 'avaliacao-' . Auth::id() . '-' . time() . '.' . $arquivo->getClientOriginalExtension();
            
            // Criar diretório se não existir
            $diretorio = public_path('uploads/avaliacoes');
            if (!file_exists($diretorio)) {
                mkdir($diretorio, 0755, true);
            }
            
            // Mover arquivo para public
            $arquivo->move($diretorio, $nomeArquivo);
            $dados['foto_avaliacao'] = 'uploads/avaliacoes/' . $nomeArquivo;
        }

        // Atualizar dados
        $avaliacao->fill([
            'comentario' => $dados['comentario'],
            'foto_avaliacao' => $dados['foto_avaliacao'] ?? $avaliacao->foto_avaliacao,
            'exibir_landing' => $request->has('exibir_landing'),
            'ativo' => false // Sempre volta para aprovação do professor ao editar
        ]);

        $avaliacao->save();

        return redirect()
            ->route('aluno.avaliar.index')
            ->with('success', 'Sua avaliação foi enviada e está aguardando aprovação do professor!');
    }

    /**
     * Remove a foto da avaliação.
     */
    public function removerFoto()
    {
        $avaliacao = Avaliacao::where('user_id', Auth::id())->first();
        
        if (!$avaliacao || !$avaliacao->foto_avaliacao) {
            return response()->json(['success' => false, 'message' => 'Foto não encontrada.']);
        }

        // Deletar arquivo físico
        Storage::disk('public')->delete($avaliacao->foto_avaliacao);

        // Remover do banco
        $avaliacao->update(['foto_avaliacao' => null, 'ativo' => false]);

        return response()->json(['success' => true, 'message' => 'Foto removida com sucesso.']);
    }
}