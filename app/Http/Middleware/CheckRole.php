<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Verifica se o usuário tem a role necessária para acessar a rota
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Se não está autenticado, redireciona para login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Verifica se o usuário tem a role necessária
        if (auth()->user()->role !== $role) {
            // Redireciona para o dashboard apropriado baseado na role do usuário
            return auth()->user()->role === 'professor' 
                ? redirect()->route('professor.dashboard')
                : redirect()->route('aluno.dashboard');
        }

        return $next($request);
    }
}
