<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Dashboard principal do professor
     */
    public function index()
    {
        try {
            Log::info('Acesso ao dashboard do professor', [
                'user_id' => auth()->id(),
                'email' => auth()->user()->email
            ]);

            return view('professor.dashboard');

        } catch (\Exception $e) {
            Log::error('Erro ao carregar dashboard do professor', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return back()->with('error', 'Erro ao carregar dashboard. Tente novamente.');
        }
    }
}
