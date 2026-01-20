<?php

namespace App\Http\Controllers\Aluno;

use App\Http\Controllers\Controller;
use App\Models\Configuracao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MensalidadeVencidaController extends Controller
{
    /**
     * Exibe página informando sobre mensalidade vencida
     */
    public function index()
    {
        $user = Auth::user();
        
        // Verifica se realmente é um aluno inativo
        if ($user->role !== 'aluno' || $user->status === 'ativo') {
            return redirect()->route('aluno.dashboard');
        }

        // Pega as configurações de contato e PIX
        $config = Configuracao::first();
        
        return view('aluno.mensalidade-vencida.index', compact('user', 'config'));
    }
}