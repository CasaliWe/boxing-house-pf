<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Mail\CredenciaisAlunoMail;
use App\Models\Horario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AprovacaoController extends Controller
{
    public function index()
    {
        $pendentes = User::where('role', 'aluno')
            ->where('status', 'pendente')
            ->with(['horarios' => function($q){
                $q->orderBy('dia_semana')->orderBy('hora_inicio');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('professor.aprovacoes.index', compact('pendentes'));
    }

    public function aprovar(Request $request, User $user)
    {
        if ($user->role !== 'aluno' || $user->status !== 'pendente') {
            return back()->with('error', 'Usuário inválido para aprovação.');
        }

        // Gerar senha inicial: nome (sem espaços, minúsculo) + 123
        $base = Str::lower(Str::of($user->name)->replace(' ', ''));
        $plain = $base.'123';
        $user->password = Hash::make($plain);
        $user->status = 'ativo';
        $user->vencimento_at = $user->vencimento_at ?: Carbon::now()->addDays(30)->toDateString();
        $user->save();

        // Aprovar horários se houver vaga
        $aprovados = [];
        $lotados = [];
        $horarios = $user->horarios()->get();
        foreach ($horarios as $h) {
            // apenas se ainda não aprovado
            $pivot = $h->alunos()->where('users.id', $user->id)->first();
            $jaAprovado = $pivot && $pivot->pivot && $pivot->pivot->aprovado;
            if ($jaAprovado) {
                continue;
            }

            $ocupadas = $h->alunos()->wherePivot('aprovado', true)->count();
            if ($ocupadas < Horario::LIMITE_ALUNOS) {
                $user->horarios()->updateExistingPivot($h->id, ['aprovado' => true]);
                $aprovados[] = $h->dia_semana_label.' '.$h->hora_inicio;
            } else {
                $lotados[] = $h->dia_semana_label.' '.$h->hora_inicio;
            }
        }

        // Tentar enviar e-mail com credenciais
        try {
            Mail::to($user->email)->send(new CredenciaisAlunoMail($user, $plain));
        } catch (\Throwable $e) {
            Log::error('Falha ao enviar e-mail de credenciais: '.$e->getMessage());
        }

        $msg = 'Aluno aprovado com sucesso.';
        if (!empty($aprovados)) {
            $msg .= ' Horários aprovados: '.implode(', ', $aprovados).'.';
        }
        if (!empty($lotados)) {
            $msg .= ' Sem vagas em: '.implode(', ', $lotados).'.';
        }

        return redirect()->route('professor.aprovacoes.index')->with('success', $msg);
    }
}
