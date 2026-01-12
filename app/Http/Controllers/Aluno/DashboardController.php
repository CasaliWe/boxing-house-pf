<?php

namespace App\Http\Controllers\Aluno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Dashboard principal do aluno
     */
    public function index()
    {
        try {
            Log::info('Acesso ao dashboard do aluno', [
                'user_id' => auth()->id(),
                'email' => auth()->user()->email
            ]);

            return view('aluno.dashboard');

        } catch (\Exception $e) {
            Log::error('Erro ao carregar dashboard do aluno', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return back()->with('error', 'Erro ao carregar dashboard. Tente novamente.');
        }
    }
}
