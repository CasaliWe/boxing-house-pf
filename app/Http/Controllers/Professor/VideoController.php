<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\VideoModulo;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VideoController extends Controller
{
    /**
     * Lista módulos de vídeos.
     */
    public function index()
    {
        $modulos = VideoModulo::with('videos')
            ->withCount('videos')
            ->ordenados()
            ->paginate(12);
            
        return view('professor.videos.index', compact('modulos'));
    }

    /**
     * Form criar módulo.
     */
    public function create()
    {
        $temas = [
            'ataque' => 'Ataque',
            'combinacoes' => 'Combinações',
            'deslocamento' => 'Deslocamento',
            'guarda' => 'Guarda',
            'equipamentos' => 'Equipamentos',
            'fundamentos' => 'Fundamentos',
            'avancado' => 'Avançado',
            'outros' => 'Outros'
        ];

        return view('professor.videos.create', compact('temas'));
    }

    /**
     * Salvar novo módulo.
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'descricao' => ['nullable', 'string'],
            'tema' => ['required', Rule::in(['ataque', 'combinacoes', 'deslocamento', 'guarda', 'equipamentos', 'fundamentos', 'avancado', 'outros'])],
            'aula_minima_acesso' => ['required', 'integer', 'min:1', 'max:100'],
            'ativo' => ['nullable', 'boolean'],
            'ordem' => ['nullable', 'integer', 'min:0'],
        ]);

        $dados['ativo'] = $request->has('ativo');
        $dados['ordem'] = $dados['ordem'] ?? 0;

        VideoModulo::create($dados);

        return redirect()->route('professor.videos.index')
            ->with('success', 'Módulo criado com sucesso!');
    }

    /**
     * Mostrar módulo específico com seus vídeos.
     */
    public function show(VideoModulo $modulo)
    {
        $modulo->load(['videos' => function($query) {
            $query->ordenados();
        }]);

        return view('professor.videos.show', compact('modulo'));
    }

    /**
     * Form editar módulo.
     */
    public function edit(VideoModulo $modulo)
    {
        $temas = [
            'ataque' => 'Ataque',
            'combinacoes' => 'Combinações',
            'deslocamento' => 'Deslocamento',
            'guarda' => 'Guarda',
            'equipamentos' => 'Equipamentos',
            'fundamentos' => 'Fundamentos',
            'avancado' => 'Avançado',
            'outros' => 'Outros'
        ];

        return view('professor.videos.edit', compact('modulo', 'temas'));
    }

    /**
     * Atualizar módulo.
     */
    public function update(Request $request, VideoModulo $modulo)
    {
        $dados = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'descricao' => ['nullable', 'string'],
            'tema' => ['required', Rule::in(['ataque', 'combinacoes', 'deslocamento', 'guarda', 'equipamentos', 'fundamentos', 'avancado', 'outros'])],
            'aula_minima_acesso' => ['required', 'integer', 'min:1', 'max:100'],
            'ativo' => ['nullable', 'boolean'],
            'ordem' => ['nullable', 'integer', 'min:0'],
        ]);

        $dados['ativo'] = $request->has('ativo');

        $modulo->update($dados);

        return redirect()->route('professor.videos.index')
            ->with('success', 'Módulo atualizado com sucesso!');
    }

    /**
     * Deletar módulo.
     */
    public function destroy(VideoModulo $modulo)
    {
        // Deletar arquivos de vídeo
        foreach ($modulo->videos as $video) {
            if ($video->arquivo_path) {
                $caminhoArquivo = public_path($video->arquivo_path);
                if (file_exists($caminhoArquivo)) {
                    unlink($caminhoArquivo);
                }
            }
        }

        $modulo->delete();

        return redirect()->route('professor.videos.index')
            ->with('success', 'Módulo deletado com sucesso!');
    }

    /**
     * Form adicionar vídeo ao módulo.
     */
    public function addVideo(VideoModulo $modulo)
    {
        return view('professor.videos.add-video', compact('modulo'));
    }

    /**
     * Salvar vídeo no módulo.
     */
    public function storeVideo(Request $request, VideoModulo $modulo)
    {
        $dados = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'descricao' => ['nullable', 'string'],
            'arquivo' => ['required', 'file', 'mimetypes:video/mp4,video/mpeg,video/quicktime,video/webm,video/x-msvideo', 'max:102400'], // 100MB max
            'ativo' => ['nullable', 'boolean'],
            'ordem' => ['nullable', 'integer', 'min:0'],
        ]);

        // Upload do vídeo
        $arquivo = $request->file('arquivo');
        $nomeArquivo = 'video-' . time() . '-' . uniqid() . '.' . $arquivo->getClientOriginalExtension();
        
        // Criar diretório se não existir
        $diretorio = public_path('uploads/videos');
        if (!file_exists($diretorio)) {
            mkdir($diretorio, 0755, true);
        }
        
        // Mover arquivo para public
        $arquivo->move($diretorio, $nomeArquivo);
        $path = 'uploads/videos/' . $nomeArquivo;

        // Tentar extrair duração (opcional - precisa ffmpeg)
        $duracaoSegundos = 0;
        try {
            $fullPath = storage_path('app/public/' . $path);
            if (function_exists('shell_exec') && is_file($fullPath)) {
                $output = shell_exec("ffprobe -v quiet -show_entries format=duration -hide_banner -of csv=p=0 \"$fullPath\"");
                if ($output) {
                    $duracaoSegundos = (int) floatval(trim($output));
                }
            }
        } catch (\Exception $e) {
            // Se não conseguir extrair duração, continua com 0
        }

        Video::create([
            'video_modulo_id' => $modulo->id,
            'titulo' => $dados['titulo'],
            'descricao' => $dados['descricao'] ?? null,
            'arquivo_path' => $path,
            'duracao_segundos' => $duracaoSegundos,
            'ativo' => $request->has('ativo'),
            'ordem' => $dados['ordem'] ?? 0,
        ]);

        return redirect()->route('professor.videos.show', $modulo)
            ->with('success', 'Vídeo adicionado com sucesso!');
    }

    /**
     * Form editar vídeo.
     */
    public function editVideo(VideoModulo $modulo, Video $video)
    {
        return view('professor.videos.edit-video', compact('modulo', 'video'));
    }

    /**
     * Atualizar vídeo.
     */
    public function updateVideo(Request $request, VideoModulo $modulo, Video $video)
    {
        $dados = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'descricao' => ['nullable', 'string'],
            'arquivo' => ['nullable', 'file', 'mimetypes:video/mp4,video/mpeg,video/quicktime,video/webm,video/x-msvideo', 'max:102400'],
            'ativo' => ['nullable', 'boolean'],
            'ordem' => ['nullable', 'integer', 'min:0'],
        ]);

        // Se enviou novo arquivo
        if ($request->hasFile('arquivo')) {
            // Deletar arquivo antigo
            if ($video->arquivo_path) {
                $caminhoAntigo = public_path($video->arquivo_path);
                if (file_exists($caminhoAntigo)) {
                    unlink($caminhoAntigo);
                }
            }

            // Upload novo arquivo
            $arquivo = $request->file('arquivo');
            $nomeArquivo = 'video-' . time() . '-' . uniqid() . '.' . $arquivo->getClientOriginalExtension();
            
            // Criar diretório se não existir
            $diretorio = public_path('uploads/videos');
            if (!file_exists($diretorio)) {
                mkdir($diretorio, 0755, true);
            }
            
            // Mover arquivo para public
            $arquivo->move($diretorio, $nomeArquivo);
            $path = 'uploads/videos/' . $nomeArquivo;
            $dados['arquivo_path'] = $path;

            // Tentar extrair nova duração
            $duracaoSegundos = 0;
            try {
                $fullPath = storage_path('app/public/' . $path);
                if (function_exists('shell_exec') && is_file($fullPath)) {
                    $output = shell_exec("ffprobe -v quiet -show_entries format=duration -hide_banner -of csv=p=0 \"$fullPath\"");
                    if ($output) {
                        $duracaoSegundos = (int) floatval(trim($output));
                    }
                }
            } catch (\Exception $e) {
                // Se não conseguir extrair duração, continua com anterior
                $duracaoSegundos = $video->duracao_segundos;
            }
            
            $dados['duracao_segundos'] = $duracaoSegundos;
        }

        $dados['ativo'] = $request->has('ativo');

        $video->update($dados);

        return redirect()->route('professor.videos.show', $modulo)
            ->with('success', 'Vídeo atualizado com sucesso!');
    }

    /**
     * Deletar vídeo.
     */
    public function destroyVideo(VideoModulo $modulo, Video $video)
    {
        // Deletar arquivo
        if ($video->arquivo_path) {
            $caminhoArquivo = public_path($video->arquivo_path);
            if (file_exists($caminhoArquivo)) {
                unlink($caminhoArquivo);
            }
        }

        $video->delete();

        return redirect()->route('professor.videos.show', $modulo)
            ->with('success', 'Vídeo deletado com sucesso!');
    }
}