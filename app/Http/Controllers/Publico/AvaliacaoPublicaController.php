<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Models\Avaliacao;
use App\Models\Configuracao;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;

class AvaliacaoPublicaController extends Controller
{
    /**
     * Exibe o formulário público de avaliação.
     */
    public function index()
    {
        $config = Configuracao::first();

        return view('public.avaliar', compact('config'));
    }

    /**
     * Salva a avaliação pública (sem autenticação).
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome_publico' => ['required', 'string', 'max:255'],
            'comentario' => ['required', 'string', 'min:10', 'max:500'],
            'foto_avaliacao' => ['nullable', File::image()->max(5120)],
        ], [
            'nome_publico.required' => 'Informe seu nome.',
            'nome_publico.max' => 'O nome deve ter no máximo 255 caracteres.',
            'comentario.required' => 'O comentário é obrigatório.',
            'comentario.min' => 'O comentário deve ter pelo menos 10 caracteres.',
            'comentario.max' => 'O comentário não pode ter mais de 500 caracteres.',
            'foto_avaliacao.image' => 'O arquivo deve ser uma imagem.',
            'foto_avaliacao.max' => 'A imagem deve ter no máximo 5MB.',
        ]);

        // Processar foto se enviada
        $caminhoFoto = null;
        if ($request->hasFile('foto_avaliacao')) {
            $arquivo = $request->file('foto_avaliacao');
            $nomeArquivo = 'avaliacao-pub-' . time() . '-' . uniqid() . '.' . $arquivo->getClientOriginalExtension();

            $diretorio = public_path('uploads/avaliacoes');
            if (!file_exists($diretorio)) {
                mkdir($diretorio, 0755, true);
            }

            $arquivo->move($diretorio, $nomeArquivo);
            $caminhoFoto = 'uploads/avaliacoes/' . $nomeArquivo;
        }

        Avaliacao::create([
            'user_id' => null,
            'nome_publico' => $dados['nome_publico'],
            'comentario' => $dados['comentario'],
            'foto_avaliacao' => $caminhoFoto,
            'exibir_landing' => true,
            'ativo' => false,
        ]);

        return redirect()
            ->route('avaliar.publica')
            ->with('success', 'Obrigado pela sua avaliação! Ela será revisada e publicada em breve.');
    }
}
