<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MensalidadeController extends Controller
{
    /**
     * Lista alunos inativos por mensalidade vencida
     */
    public function index()
    {
        $alunosInativos = User::where('role', 'aluno')
            ->where('status', 'inativo')
            ->whereNotNull('vencimento_at')
            ->orderBy('vencimento_at', 'desc')
            ->paginate(20);

        return view('professor.mensalidades.index', compact('alunosInativos'));
    }

    /**
     * Reativa aluno e atualiza vencimento
     */
    public function reativar(Request $request, User $user)
    {
        if ($user->role !== 'aluno') {
            return back()->with('error', 'Ação inválida.');
        }

        $dados = $request->validate([
            'novo_vencimento' => ['required', 'date', 'after:today'],
        ]);

        $user->status = 'ativo';
        $user->vencimento_at = $dados['novo_vencimento'];
        $user->save();

        return back()->with('success', "Aluno {$user->name} reativado com vencimento para " . Carbon::parse($dados['novo_vencimento'])->format('d/m/Y'));
    }
}