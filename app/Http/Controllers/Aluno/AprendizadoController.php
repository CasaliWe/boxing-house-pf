<?php

namespace App\Http\Controllers\Aluno;

use App\Http\Controllers\Controller;
use App\Models\VideoModulo;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AprendizadoController extends Controller
{
    /**
     * Lista módulos disponíveis para o aluno baseado no número de aulas.
     */
    public function index()
    {
        $aluno = Auth::user();
        $numeroAulasAluno = $aluno->treinos()->count();

        $modulosDisponiveis = VideoModulo::ativos()
            ->where('aula_minima_acesso', '<=', $numeroAulasAluno)
            ->withCount('videos')
            ->ordenados()
            ->get();

        $proximosModulos = VideoModulo::ativos()
            ->where('aula_minima_acesso', '>', $numeroAulasAluno)
            ->withCount('videos')
            ->ordenados()
            ->take(3)
            ->get();

        return view('aluno.aprendizado.index', compact('modulosDisponiveis', 'proximosModulos', 'numeroAulasAluno'));
    }

    /**
     * Visualizar módulo específico com seus vídeos.
     */
    public function show(VideoModulo $modulo)
    {
        $aluno = Auth::user();

        // Verificar se aluno tem acesso
        if (!$modulo->alunoTemAcesso($aluno)) {
            return redirect()->route('aluno.aprendizado.index')
                ->with('error', 'Você ainda não tem acesso a este módulo.');
        }

        if (!$modulo->ativo) {
            return redirect()->route('aluno.aprendizado.index')
                ->with('error', 'Módulo não está disponível.');
        }

        $modulo->load(['videos' => function($query) {
            $query->ativos()->ordenados();
        }]);

        return view('aluno.aprendizado.show', compact('modulo'));
    }

    /**
     * Visualizar vídeo específico.
     */
    public function video(VideoModulo $modulo, Video $video)
    {
        $aluno = Auth::user();

        // Verificar acessos
        if (!$modulo->alunoTemAcesso($aluno) || !$modulo->ativo || !$video->ativo) {
            return redirect()->route('aluno.aprendizado.index')
                ->with('error', 'Você não tem acesso a este conteúdo.');
        }

        // Verificar se vídeo pertence ao módulo
        if ($video->video_modulo_id !== $modulo->id) {
            return redirect()->route('aluno.aprendizado.show', $modulo)
                ->with('error', 'Vídeo não encontrado neste módulo.');
        }

        // Buscar outros vídeos do módulo para navegação
        $outrosVideos = $modulo->videos()
            ->ativos()
            ->where('id', '!=', $video->id)
            ->ordenados()
            ->get();

        return view('aluno.aprendizado.video', compact('modulo', 'video', 'outrosVideos'));
    }
}