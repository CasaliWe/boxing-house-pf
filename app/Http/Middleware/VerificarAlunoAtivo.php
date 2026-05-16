<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerificarAlunoAtivo
{
    /**
     * Verifica apenas se o cadastro esta ativo.
     * Saldo zerado de aulas nao bloqueia acesso ao sistema.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'aluno') {
            return $next($request);
        }

        if ($user->status === 'inativo') {
            if (!$request->routeIs('aluno.mensalidade-vencida') && !$request->routeIs('logout')) {
                return redirect()->route('aluno.mensalidade-vencida');
            }
        }

        return $next($request);
    }
}
