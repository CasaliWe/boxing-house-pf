<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Models\Configuracao;
use App\Models\FotoCentro;
use App\Models\ValorPlano;
use App\Models\Horario;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Exibir a landing page
     */
    public function index()
    {
        // Configurações gerais
        $config = Configuracao::first();
        
        // Fotos do centro de treinamento (campo ativo existe)
        $fotosCentro = FotoCentro::where('ativo', true)->orderBy('ordem')->orderBy('id')->get();
        
        // Valores dos planos (sem campo ativo)
        $valores = ValorPlano::orderBy('vezes_semana')->get();
        
        // Horários disponíveis agrupados por dia (sem campo ativo, sem função FIELD no SQLite)
        $horarios = Horario::orderBy('dia_semana')
            ->orderBy('hora_inicio')
            ->get()
            ->groupBy('dia_semana');

        return view('landing.index', compact('config', 'fotosCentro', 'valores', 'horarios'));
    }
}