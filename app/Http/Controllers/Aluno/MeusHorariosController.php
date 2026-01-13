<?php

namespace App\Http\Controllers\Aluno;

use App\Http\Controllers\Controller;
use App\Models\Horario;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MeusHorariosController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load(['horarios' => function($q){
            $q->orderBy('dia_semana')->orderBy('hora_inicio');
        }]);
        $horarios = Horario::orderBy('dia_semana')->orderBy('hora_inicio')->get();

        return view('aluno.horarios', compact('user', 'horarios'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'horarios' => ['array'],
            'horarios.*' => ['integer', 'exists:horarios,id'],
        ]);

        $selecionados = collect($data['horarios'] ?? []);

        // Limite do plano
        $max = (int)($user->plano_vezes ?? 0);
        if ($max > 0 && $selecionados->count() > $max) {
            return back()->withErrors(['horarios' => 'Você só pode selecionar '.$max.' horário(s) conforme seu plano.'])->withInput();
        }

        // Aprovação conforme vagas
        $atuais = $user->horarios()->get()->keyBy('id');
        $syncData = [];
        foreach (Horario::whereIn('id', $selecionados)->get() as $h) {
            $aprovadoAtual = $atuais->has($h->id) ? (bool)($atuais[$h->id]->pivot->aprovado) : false;
            $ocupadas = $h->alunos()->wherePivot('aprovado', true)
                ->when($atuais->has($h->id) && $aprovadoAtual, function($q) use ($user){
                    $q->where('users.id', '!=', $user->id);
                })
                ->count();
            $syncData[$h->id] = ['aprovado' => $ocupadas < Horario::LIMITE_ALUNOS];
        }

        $user->horarios()->sync($syncData);

        $semVaga = [];
        foreach ($syncData as $hid => $pivot) {
            if (!$pivot['aprovado']) {
                $h = $atuais->get($hid) ?: Horario::find($hid);
                if ($h) {
                    $semVaga[] = $h->dia_semana_label.' '.Carbon::parse($h->hora_inicio)->format('H:i');
                }
            }
        }

        $msg = 'Seus horários foram atualizados.';
        if (!empty($semVaga)) {
            $msg .= ' Sem vagas em: '.implode(', ', $semVaga).'.';
        }

        return back()->with('success', $msg);
    }
}
