<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Horario;
use App\Models\AulaSequencia;
use Illuminate\Support\Carbon;
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
            $prof = auth()->user();
            Log::info('Acesso ao dashboard do professor', [
                'user_id' => $prof->id,
                'email' => $prof->email
            ]);

            // Estatísticas de alunos
            $totalAlunos = User::where('role', 'aluno')->count();
            $alunosAtivos = User::where('role', 'aluno')->where('status', 'ativo')->count();
            $alunosInativos = User::where('role', 'aluno')->where('status', 'inativo')->count();
            $alunosPendentes = User::where('role', 'aluno')->where('status', 'pendente')->count();

            // Próxima aula com base nos horários (somente com alunos ativos e aprovados)
            $horarios = Horario::with(['alunos' => function ($q) {
                $q->where('role', 'aluno')
                  ->where('status', 'ativo')
                  ->wherePivot('aprovado', true);
            }])->get();
            $now = Carbon::now();
            $nowDow = (int) $now->dayOfWeekIso; // 1..7

            $proximaAula = null; // ['horario' => Horario, 'datetime' => Carbon]
            foreach ($horarios as $h) {
                $horaInicio = Carbon::parse($h->hora_inicio);
                $horaFim = Carbon::parse($h->hora_fim);
                $targetDow = (int) $h->dia_semana;

                // Calcula próxima ocorrência para este horário
                if ($targetDow === $nowDow) {
                    $candidate = $now->copy()->setTimeFromTimeString($horaInicio->format('H:i:s'));
                    // Se a aula ainda não terminou hoje, considera como próxima
                    $fimHoje = $now->copy()->setTimeFromTimeString($horaFim->format('H:i:s'));
                    if ($fimHoje->lessThanOrEqualTo($now)) {
                        $candidate->addDays(7);
                    }
                } else {
                    $diff = $targetDow > $nowDow ? ($targetDow - $nowDow) : (7 - ($nowDow - $targetDow));
                    $candidate = $now->copy()->addDays($diff)->setTimeFromTimeString($horaInicio->format('H:i:s'));
                }

                if (is_null($proximaAula) || $candidate->lt($proximaAula['datetime'])) {
                    $proximaAula = [
                        'horario' => $h,
                        'datetime' => $candidate,
                    ];
                }
            }

            $alunosProxima = [];
            if ($proximaAula) {
                // Alunos ativos e aprovados neste horário
                $alunos = $proximaAula['horario']->alunos()
                    ->wherePivot('aprovado', true)
                    ->where('status', 'ativo')
                    ->orderBy('name')
                    ->get();
                foreach ($alunos as $aluno) {
                    $treinos = $aluno->treinos()->orderBy('data')->get();
                    $padraoCount = $treinos->where('especial', false)->count();
                    $proximaNumero = $padraoCount + 1;
                    $seq = AulaSequencia::where('numero', $proximaNumero)->where('ativo', true)->first();
                    $alunosProxima[] = [
                        'id' => $aluno->id,
                        'name' => $aluno->name,
                        'email' => $aluno->email,
                        'proxima_numero' => $proximaNumero,
                        'proxima_seq' => $seq?->descricao ?? 'Sequência não configurada',
                    ];
                }
            }

            return view('professor.dashboard', [
                'totalAlunos' => $totalAlunos,
                'alunosAtivos' => $alunosAtivos,
                'alunosInativos' => $alunosInativos,
                'alunosPendentes' => $alunosPendentes,
                'proximaAula' => $proximaAula,
                'alunosProxima' => $alunosProxima,
            ]);

        } catch (\Exception $e) {
            Log::error('Erro ao carregar dashboard do professor', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return back()->with('error', 'Erro ao carregar dashboard. Tente novamente.');
        }
    }
}
