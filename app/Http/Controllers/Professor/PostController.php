<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('data_postagem')->paginate(12);

        return view('professor.posts.index', compact('posts'));
    }

    public function create()
    {
        $post = new Post([
            'tipo' => Post::TIPO_POST,
            'data_postagem' => now()->addDay()->setMinute(0)->setSecond(0),
        ]);

        return view('professor.posts.create', compact('post'));
    }

    public function store(Request $request)
    {
        $dados = $this->validar($request);
        $dados['arquivos'] = $this->salvarArquivos($request);

        Post::create($dados);

        return redirect()->route('professor.posts.index')
            ->with('success', 'Post criado com sucesso.');
    }

    public function edit(Post $post)
    {
        return view('professor.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $dados = $this->validar($request);
        $novosArquivos = $this->salvarArquivos($request);
        $dados['arquivos'] = array_values(array_merge($post->arquivos ?? [], $novosArquivos));

        $post->update($dados);

        return redirect()->route('professor.posts.index')
            ->with('success', 'Post atualizado com sucesso.');
    }

    public function destroy(Post $post)
    {
        foreach ($post->arquivos ?? [] as $arquivo) {
            $caminho = public_path($arquivo['caminho'] ?? '');
            if ($caminho && file_exists($caminho)) {
                unlink($caminho);
            }
        }

        $post->delete();

        return redirect()->route('professor.posts.index')
            ->with('success', 'Post excluido com sucesso.');
    }

    private function validar(Request $request): array
    {
        return $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'tipo' => ['required', 'in:' . implode(',', array_keys(Post::TIPOS))],
            'data_postagem' => ['required', 'date'],
            'legenda' => ['nullable', 'string'],
            'arquivos' => ['nullable', 'array'],
            'arquivos.*' => ['file'],
        ]);
    }

    private function salvarArquivos(Request $request): array
    {
        if (!$request->hasFile('arquivos')) {
            return [];
        }

        $diretorio = public_path('uploads/posts');
        if (!file_exists($diretorio)) {
            mkdir($diretorio, 0755, true);
        }

        $arquivos = [];
        foreach ($request->file('arquivos') as $arquivo) {
            $nomeArquivo = 'post-' . time() . '-' . uniqid() . '.' . $arquivo->getClientOriginalExtension();
            $arquivo->move($diretorio, $nomeArquivo);

            $arquivos[] = [
                'nome' => $arquivo->getClientOriginalName(),
                'caminho' => 'uploads/posts/' . $nomeArquivo,
            ];
        }

        return $arquivos;
    }
}
