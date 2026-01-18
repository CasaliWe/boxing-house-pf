<?php

namespace App\Http\Controllers\Aluno;

use App\Http\Controllers\Controller;
use App\Models\AulaSequencia;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Dashboard principal do aluno
     */
    public function index()
    {
        try {
            $user = auth()->user();
            Log::info('Acesso ao dashboard do aluno', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);

            // Próximo treino com base nos horários aprovados
            $horarios = $user->horarios()->wherePivot('aprovado', true)->get();
            $now = Carbon::now();
            $nowDow = (int) $now->dayOfWeekIso; // 1=Mon .. 7=Sun

            $proximo = null;
            foreach ($horarios as $h) {
                $horaInicio = Carbon::parse($h->hora_inicio);
                $targetDow = (int) $h->dia_semana;

                // Calcula dias até o próximo dia alvo
                if ($targetDow === $nowDow) {
                    // Hoje: se horário ainda não passou, usa hoje, senão adiciona 7 dias
                    $candidate = $now->copy()->setTimeFromTimeString($horaInicio->format('H:i:s'));
                    if ($candidate->lessThanOrEqualTo($now)) {
                        $candidate->addDays(7);
                    }
                } else {
                    $diff = $targetDow > $nowDow ? ($targetDow - $nowDow) : (7 - ($nowDow - $targetDow));
                    $candidate = $now->copy()->addDays($diff)->setTimeFromTimeString($horaInicio->format('H:i:s'));
                }

                if (is_null($proximo) || $candidate->lt($proximo['date'])) {
                    $proximo = [
                        'date' => $candidate,
                        'dia_label' => $h->dia_semana_label,
                        'hora' => $horaInicio->format('H:i'),
                    ];
                }
            }

            // Total de aulas (especial + sequencial)
            $totalAulas = $user->treinos()->count();

            // Lista de aprendizados: mapeia aulas padrão para sequência
            $treinos = $user->treinos()->orderBy('data')->get();
            $aprendizados = [];
            $contadorPadrao = 0;
            foreach ($treinos as $t) {
                if (!$t->especial) {
                    $contadorPadrao++;
                    $seq = AulaSequencia::where('numero', $contadorPadrao)->where('ativo', true)->first();
                    $aprendizados[] = [
                        'numero' => $contadorPadrao,
                        'descricao' => $seq?->descricao ?? 'Sequência não configurada',
                        'video_path' => $seq?->video_path,
                    ];
                }
            }

            return view('aluno.dashboard', [
                'proximoTreino' => $proximo,
                'totalAulas' => $totalAulas,
                'aprendizados' => $aprendizados,
            ]);

        } catch (\Exception $e) {
            Log::error('Erro ao carregar dashboard do aluno', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return back()->with('error', 'Erro ao carregar dashboard. Tente novamente.');
        }
    }
}
