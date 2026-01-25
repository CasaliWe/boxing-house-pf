<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Avaliacao;
use Illuminate\Http\Request;

class AvaliacaoController extends Controller
{
    /**
     * Exibe a lista de avaliações para aprovação.
     */
    public function index()
    {
        $avaliacoes = Avaliacao::with('user')
            ->orderBy('ativo', 'asc') // Pendentes primeiro
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('professor.avaliacoes.index', compact('avaliacoes'));
    }

    /**
     * Aprova uma avaliação.
     */
    public function aprovar(Avaliacao $avaliacao)
    {
        $avaliacao->update(['ativo' => true]);
        
        return redirect()
            ->route('professor.avaliacoes.index')
            ->with('success', 'Avaliação aprovada com sucesso!');
    }

    /**
     * Reprova uma avaliação.
     */
    public function reprovar(Avaliacao $avaliacao)
    {
        $avaliacao->update(['ativo' => false]);
        
        return redirect()
            ->route('professor.avaliacoes.index')
            ->with('success', 'Avaliação reprovada.');
    }

    /**
     * Exclui uma avaliação.
     */
    public function destroy(Avaliacao $avaliacao)
    {
        // Remover foto se existir
        if ($avaliacao->foto_avaliacao) {
            $caminhoArquivo = public_path($avaliacao->foto_avaliacao);
            if (file_exists($caminhoArquivo)) {
                unlink($caminhoArquivo);
            }
        }
        
        $avaliacao->delete();
        
        return redirect()
            ->route('professor.avaliacoes.index')
            ->with('success', 'Avaliação excluída com sucesso!');
    }
}