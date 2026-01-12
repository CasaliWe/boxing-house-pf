<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class AlunoController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status'); // opcional: ativo, inativo, pendente
        $query = User::where('role', 'aluno')->with(['horarios' => function($q){
            $q->orderBy('dia_semana')->orderBy('hora_inicio');
        }]);
        if (in_array($status, ['ativo','inativo','pendente'])) {
            $query->where('status', $status);
        }
        $alunos = $query->orderBy('name')->paginate(20)->withQueryString();

        return view('professor.alunos.index', compact('alunos', 'status'));
    }

    public function alterarSenha(Request $request, User $user)
    {
        if ($user->role !== 'aluno') {
            return back()->with('error', 'Ação inválida.');
        }

        $data = $request->validate([
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user->password = Hash::make($data['password']);
        $user->save();

        return back()->with('success', 'Senha alterada com sucesso.');
    }

    public function destroy(User $user)
    {
        if ($user->role !== 'aluno') {
            return back()->with('error', 'Ação inválida.');
        }

        // Remove vínculos para manter integridade
        $user->horarios()->detach();
        $user->delete();

        return back()->with('success', 'Aluno removido.');
    }

    // Helper para status de vencimento - pode ser usado na view via closure
    public static function vencimentoStatus(?string $date): string
    {
        if(!$date) return 'desconhecido';
        $v = Carbon::parse($date)->startOfDay();
        $hoje = Carbon::today();
        if ($hoje->gt($v)) return 'vencida';
        $dias = $hoje->diffInDays($v, false);
        if ($dias <= 2) return 'vencendo';
        return 'ok';
    }
}
