@extends('layouts.app')

@section('title', 'Meus Horários')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-semibold text-blue-400 mb-4">🗓️ Meus Horários</h1>
    @error('horarios')
        <div class="mb-4 px-4 py-3 bg-red-700 text-white rounded">{{ $message }}</div>
    @enderror

    <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 space-y-4">
        <div>
            <div class="text-gray-400 text-sm mb-2">Horários selecionados atualmente</div>
            @if($user->horarios->isEmpty())
                <div class="text-gray-300">Nenhum</div>
            @else
                <ul class="list-disc pl-6 text-gray-200">
                    @foreach($user->horarios as $h)
                        <li>{{ $h->dia_semana_label }} - {{ \Illuminate\Support\Carbon::parse($h->hora_inicio)->format('H:i') }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <form method="POST" action="{{ route('aluno.horarios.update') }}" class="space-y-4" data-max="{{ (int)($user->plano_vezes ?? 0) }}">
            @csrf
            @method('PUT')
            @php $selecionados = $user->horarios->pluck('id')->all(); @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @foreach($horarios as $h)
                    @php
                        $temVaga = $h->vagas_disponiveis > 0;
                        $jaSelecionado = in_array($h->id, $selecionados);
                    @endphp
                    <label class="flex items-center gap-2 bg-gray-800 border border-gray-700 rounded p-2">
                        <input type="checkbox" name="horarios[]" value="{{ $h->id }}" class="rounded"
                               {{ $jaSelecionado ? 'checked' : '' }}
                               {{ !$temVaga && !$jaSelecionado ? 'disabled' : '' }}
                               data-initial-disabled="{{ (!$temVaga && !$jaSelecionado) ? '1' : '0' }}">
                        <span class="text-gray-200">
                            {{ $h->dia_semana_label }} - {{ \Illuminate\Support\Carbon::parse($h->hora_inicio)->format('H:i') }}
                            <span class="ml-2 text-xs px-2 py-0.5 rounded {{ $temVaga ? 'bg-green-700 text-white' : 'bg-red-700 text-white' }}">
                                {{ $temVaga ? ($h->vagas_disponiveis.' vaga(s)') : 'FULL' }}
                            </span>
                        </span>
                    </label>
                @endforeach
            </div>
            <div class="text-red-400 text-sm hidden" data-limit-warning></div>
            <div class="text-xs text-gray-400" data-counter></div>
            <div class="text-xs text-gray-400">Seu plano: {{ $user->plano_vezes ?: '-' }}x/semana. Respeite o limite ao selecionar.</div>
            <div>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">Salvar horários</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function(){
        const form = document.querySelector('form[data-max]');
        if (form) {
            const max = parseInt(form.dataset.max, 10);
            const warn = form.querySelector('[data-limit-warning]');
            const counter = form.querySelector('[data-counter]');
            const boxes = Array.from(form.querySelectorAll('input[name="horarios[]"]'));
            const showWarn = (msg) => { if (warn) { warn.textContent = msg; warn.classList.remove('hidden'); } };
            const hideWarn = () => { if (warn) { warn.classList.add('hidden'); } };
            const updateState = () => {
                const checkedCount = boxes.filter(b => b.checked).length;
                if (counter) {
                    if (Number.isFinite(max) && max > 0) counter.textContent = `Selecionados: ${checkedCount} de ${max}`; else counter.textContent = '';
                }
                hideWarn();
                if (Number.isFinite(max) && max > 0) {
                    const limitReached = checkedCount >= max;
                    boxes.forEach(b => {
                        if (!b.checked) {
                            const initiallyDisabled = b.dataset.initialDisabled === '1';
                            b.disabled = limitReached ? true : (initiallyDisabled ? true : false);
                        }
                    });
                }
            };
            boxes.forEach(box => {
                box.addEventListener('change', () => {
                    const checkedCount = boxes.filter(b => b.checked).length;
                    if (Number.isFinite(max) && max > 0 && checkedCount > max) {
                        box.checked = false;
                        showWarn(`Você só pode selecionar ${max} horário(s) conforme o plano.`);
                    }
                    updateState();
                });
            });
            updateState();
        }
    });
</script>
@endsection
