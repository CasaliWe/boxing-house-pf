<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Horario;
use App\Models\User;
use App\Models\ValorPlano;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class AlunoController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query = User::where('role', 'aluno')->with(['horarios' => function ($q) {
            $q->orderBy('dia_semana')->orderBy('hora_inicio');
        }]);

        if (in_array($status, ['ativo', 'inativo', 'pendente'])) {
            $query->where('status', $status);
        }

        $alunos = $query->orderBy('name')->paginate(20)->withQueryString();
        $horarios = Horario::orderBy('dia_semana')->orderBy('hora_inicio')->get();
        $pacotes = ValorPlano::pacotes()->orderBy('aulas_mes')->get();

        return view('professor.alunos.index', compact('alunos', 'status', 'horarios', 'pacotes'));
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

        $user->horarios()->detach();
        $user->delete();

        return back()->with('success', 'Aluno removido.');
    }

    public static function vencimentoStatus(?string $date): string
    {
        if (!$date) {
            return 'desconhecido';
        }

        $vencimento = Carbon::parse($date)->startOfDay();
        $hoje = Carbon::today();

        if ($hoje->gt($vencimento)) {
            return 'vencida';
        }

        $dias = $hoje->diffInDays($vencimento, false);

        if ($dias <= 2) {
            return 'vencendo';
        }

        return 'ok';
    }

    /**
     * Atualiza pacote de aulas e horarios vinculados ao aluno.
     */
    public function atualizarHorarios(Request $request, User $user)
    {
        if ($user->role !== 'aluno') {
            return back()->with('error', 'Ação inválida.');
        }

        $data = $request->validate([
            'aulas_contratadas' => ['nullable', 'integer', 'min:1', 'max:100'],
            'aulas_restantes' => ['nullable', 'integer', 'min:0', 'max:100'],
            'valor_aula' => ['nullable', 'numeric', 'min:0'],
            'horarios' => ['array'],
            'horarios.*' => ['integer', 'exists:horarios,id'],
        ]);

        if (isset($data['aulas_contratadas'])) {
            $aulas = (int) $data['aulas_contratadas'];
            $pacote = ValorPlano::pacoteParaQuantidade($aulas);
            $valorAula = isset($data['valor_aula'])
                ? (float) $data['valor_aula']
                : (float) ($pacote?->valor_aula ?? 0);
            $restantes = isset($data['aulas_restantes'])
                ? min((int) $data['aulas_restantes'], $aulas)
                : $aulas;

            $user->registrarPacoteAulas($aulas, $valorAula, $restantes);
            $user->refresh();
        }

        $selecionados = collect($data['horarios'] ?? [])->unique()->values();
        $max = (int) ($user->limite_horarios ?? 0);

        if ($max > 0 && $selecionados->count() > $max) {
            return back()->withErrors([
                'horarios' => 'Você só pode selecionar ' . $max . ' horário(s) conforme o pacote de aulas.',
            ])->withInput();
        }

        $atuais = $user->horarios()->get()->keyBy('id');
        $syncData = [];

        foreach (Horario::whereIn('id', $selecionados)->get() as $horario) {
            $aprovadoAtual = $atuais->has($horario->id) ? (bool) ($atuais[$horario->id]->pivot->aprovado) : false;
            $ocupadas = $horario->alunos()->wherePivot('aprovado', true)
                ->when($atuais->has($horario->id) && $aprovadoAtual, function ($q) use ($user) {
                    $q->where('users.id', '!=', $user->id);
                })
                ->count();

            $syncData[$horario->id] = ['aprovado' => $ocupadas < $horario->limite_alunos];
        }

        $user->horarios()->sync($syncData);

        $semVaga = [];
        foreach ($syncData as $horarioId => $pivot) {
            if (!$pivot['aprovado']) {
                $horario = $atuais->get($horarioId) ?: Horario::find($horarioId);
                if ($horario) {
                    $semVaga[] = $horario->dia_semana_label . ' ' . Carbon::parse($horario->hora_inicio)->format('H:i');
                }
            }
        }

        $msg = 'Dados do aluno atualizados.';
        if (!empty($semVaga)) {
            $msg .= ' Sem vagas em: ' . implode(', ', $semVaga) . '.';
        }

        return back()->with('success', $msg);
    }
}
