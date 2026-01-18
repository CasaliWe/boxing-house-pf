<?php

namespace App\Http\Controllers\Aluno;

use App\Http\Controllers\Controller;
use App\Models\AulaSequencia;
use Illuminate\Support\Facades\Auth;

class TreinosController extends Controller
{
    /**
     * Lista treinos do aluno com numeração e sequência.
     */
    public function index()
    {
        $user = Auth::user();

        // Ordena por data ascendente para numeração linear
        $treinos = $user->treinos()->orderBy('data')->get();

        // Mapeia com número da aula e dados de vídeo
        $treinosNumerados = $treinos->values()->map(function ($treino, $idx) {
            $numeroAula = $idx + 1;
            $treino->numero_aula = $treino->especial ? null : $numeroAula;
            
            // Se não for especial, buscar sequência com vídeo
            if (!$treino->especial) {
                $sequencia = AulaSequencia::where('numero', $numeroAula)->where('ativo', true)->first();
                $treino->sequencia = $sequencia;
                $treino->video_path = $sequencia?->video_path;
            }
            
            return $treino;
        });

        // Próxima aula prevista (se não for especial)
        $proximaNumero = $treinosNumerados->filter(function ($t) {
            return !$t->especial;
        })->count() + 1;

        $proximaSequencia = AulaSequencia::where('numero', $proximaNumero)->where('ativo', true)->first();

        return view('aluno.treinos.index', [
            'treinos' => $treinosNumerados,
            'proximaNumero' => $proximaNumero,
            'proximaSequencia' => $proximaSequencia,
        ]);
    }
}
