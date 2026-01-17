<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Horario;
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

        // Lista de horários disponíveis para edição no modal
        $horarios = Horario::orderBy('dia_semana')->orderBy('hora_inicio')->get();

        return view('professor.alunos.index', compact('alunos', 'status', 'horarios'));
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

    /**
     * Atualiza os horários vinculados ao aluno.
     * Não aprova aqui; apenas sincroniza seleção (aprovado=false).
     */
    public function atualizarHorarios(Request $request, User $user)
    {
        if ($user->role !== 'aluno') {
            return back()->with('error', 'Ação inválida.');
        }

        $data = $request->validate([
            'horarios' => ['array'],
            'horarios.*' => ['integer', 'exists:horarios,id'],
        ]);

        $selecionados = collect($data['horarios'] ?? []);

        // Respeitar limite do plano (se definido)
        $max = (int)($user->plano_vezes ?? 0);
        if ($max > 0 && $selecionados->count() > $max) {
            return back()->withErrors(['horarios' => 'Você só pode selecionar '.$max.' horário(s) conforme o plano.'])->withInput();
        }

        // Sincroniza exatamente os IDs selecionados, marcando aprovado=false.
        $syncData = $selecionados->mapWithKeys(function ($id) {
            return [$id => ['aprovado' => false]];
        })->toArray();

        $user->horarios()->sync($syncData);

        return back()->with('success', 'Horários do aluno atualizados.');
    }
}
