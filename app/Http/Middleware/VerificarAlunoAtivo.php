<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerificarAlunoAtivo
{
    /**
     * Verifica se o aluno está ativo e com mensalidade em dia.
     * Se estiver vencida, torna inativo e redireciona para página de aviso.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        // Se não for aluno, prossegue normalmente
        if (!$user || $user->role !== 'aluno') {
            return $next($request);
        }

        // Verifica se a mensalidade está vencida e torna inativo se necessário
        if ($user->vencimento_at && Carbon::parse($user->vencimento_at)->lt(Carbon::today())) {
            if ($user->status === 'ativo') {
                $user->status = 'inativo';
                $user->save();
            }
        }

        // Se o aluno estiver inativo, redireciona para página de mensalidade
        if ($user->status === 'inativo') {
            // Permite acesso apenas à página de mensalidade vencida e logout
            if (!$request->routeIs('aluno.mensalidade-vencida') && !$request->routeIs('logout')) {
                return redirect()->route('aluno.mensalidade-vencida');
            }
        }

        return $next($request);
    }
}