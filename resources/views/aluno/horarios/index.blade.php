@extends('layouts.app')

@section('title', 'Meus Horários')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Cabeçalho da página --}}
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Meus horários</h1>
            <p class="text-sm text-gray-400 mt-1">Escolha os dias e horários em que você vai treinar</p>
        </div>
    </div>

    {{-- Erro de validação --}}
    @error('horarios')
        <div class="bg-red-500/10 border border-red-500/40 rounded-lg p-4 text-sm text-red-200">{{ $message }}</div>
    @enderror

    {{-- Resumo do pacote --}}
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg p-5">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs text-gray-400 uppercase tracking-wider">Pacote</span>
                <div class="w-8 h-8 rounded-md bg-blue-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-blue-400">{{ $user->aulas_contratadas ?: '-' }}</div>
            <div class="text-xs text-gray-500 mt-1">aulas/mês</div>
        </div>
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg p-5">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs text-gray-400 uppercase tracking-wider">Saldo</span>
                <div class="w-8 h-8 rounded-md {{ (int)$user->aulas_restantes > 0 ? 'bg-green-500/10' : 'bg-red-500/10' }} flex items-center justify-center">
                    <svg class="w-4 h-4 {{ (int)$user->aulas_restantes > 0 ? 'text-green-400' : 'text-red-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold {{ (int)$user->aulas_restantes > 0 ? 'text-green-400' : 'text-red-400' }}">{{ (int)$user->aulas_restantes }}</div>
            <div class="text-xs text-gray-500 mt-1">aulas restantes</div>
        </div>
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg p-5 col-span-2 md:col-span-1">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs text-gray-400 uppercase tracking-wider">Limite</span>
                <div class="w-8 h-8 rounded-md bg-blue-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-white">{{ (int)($user->limite_horarios ?? 0) ?: '–' }}</div>
            <div class="text-xs text-gray-500 mt-1">horários fixos por semana</div>
        </div>
    </div>

    {{-- Horários selecionados --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
            <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-white">Seus horários atuais</h3>
                <p class="text-xs text-gray-400">{{ $user->horarios->count() }} {{ $user->horarios->count() === 1 ? 'horário' : 'horários' }} selecionado(s)</p>
            </div>
        </div>

        <div class="p-6">
            @if($user->horarios->isEmpty())
                <div class="text-center py-6 text-sm text-gray-500">Nenhum horário selecionado ainda</div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    @foreach($user->horarios as $h)
                        <div class="bg-gray-800/40 border border-gray-700 rounded-md px-3 py-2.5 flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full bg-blue-500/15 flex items-center justify-center text-blue-400 text-xs font-semibold">
                                    {{ mb_substr($h->dia_semana_label, 0, 1) }}
                                </div>
                                <span class="text-sm text-gray-200">{{ $h->dia_semana_label }}</span>
                            </div>
                            <span class="text-sm font-mono font-semibold text-blue-400">{{ \Illuminate\Support\Carbon::parse($h->hora_inicio)->format('H:i') }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Form para alterar horários --}}
    <form method="POST" action="{{ route('aluno.horarios.update') }}" data-max="{{ (int)($user->limite_horarios ?? 0) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
                <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-white">Horários disponíveis</h3>
                    <p class="text-xs text-gray-400">Marque os horários que quer treinar</p>
                </div>
            </div>

            <div class="p-6 space-y-4">
                @php $selecionados = $user->horarios->pluck('id')->all(); @endphp
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    @foreach($horarios as $h)
                        @php
                            $temVaga       = $h->vagas_disponiveis > 0;
                            $jaSelecionado = in_array($h->id, $selecionados);
                        @endphp
                        <label class="block bg-gray-800/40 border {{ $jaSelecionado ? 'border-blue-500/60' : 'border-gray-700' }} rounded-md p-3 hover:border-blue-500/40 transition-colors cursor-pointer {{ (!$temVaga && !$jaSelecionado) ? 'opacity-60' : '' }}">
                            <div class="flex items-start gap-2.5">
                                <input type="checkbox" name="horarios[]" value="{{ $h->id }}"
                                       class="rounded mt-0.5 bg-gray-900 border-gray-700 text-blue-600 focus:ring-blue-500"
                                       {{ $jaSelecionado ? 'checked' : '' }}
                                       {{ !$temVaga && !$jaSelecionado ? 'disabled' : '' }}
                                       data-initial-disabled="{{ (!$temVaga && !$jaSelecionado) ? '1' : '0' }}">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-2">
                                        <div class="text-sm font-medium text-white">{{ $h->dia_semana_label }}</div>
                                        <div class="text-sm font-mono font-semibold text-blue-400">{{ \Illuminate\Support\Carbon::parse($h->hora_inicio)->format('H:i') }}</div>
                                    </div>
                                    <div class="mt-1.5">
                                        <span class="inline-block whitespace-nowrap text-xs font-semibold px-2 py-0.5 rounded {{ $temVaga ? 'bg-green-500/20 text-green-300' : 'bg-red-500/20 text-red-300' }}">
                                            {{ $temVaga ? $h->vagas_disponiveis.'/'.$h->limite_alunos.' vaga(s)' : 'LOTADO' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>

                {{-- Aviso de limite --}}
                <div class="bg-red-500/10 border border-red-500/40 rounded-md px-4 py-3 text-sm text-red-200 hidden" data-limit-warning></div>

                {{-- Contador --}}
                <div class="bg-gray-800/40 border border-gray-700 rounded-md px-4 py-3 text-sm text-gray-300" data-counter></div>
            </div>

            <div class="flex justify-end px-6 py-4 border-t border-gray-800">
                <button id="btnSalvarHorarios" type="submit"
                        style="background-color: #2563eb; color: #ffffff;"
                        onmouseover="this.style.backgroundColor='#1d4ed8'"
                        onmouseout="this.style.backgroundColor='#2563eb'"
                        class="inline-flex items-center text-sm font-medium px-5 py-2 rounded-md transition-colors">
                    <span class="btn-spin inline-block align-middle w-3.5 h-3.5 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
                    <span class="btn-text">Salvar horários</span>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        const form = document.querySelector('form[data-max]');
        if (!form) return;

        const max     = parseInt(form.dataset.max, 10);
        const warn    = form.querySelector('[data-limit-warning]');
        const counter = form.querySelector('[data-counter]');
        const boxes   = Array.from(form.querySelectorAll('input[name="horarios[]"]'));
        const btn     = document.getElementById('btnSalvarHorarios');

        // Mostra aviso temporário de limite
        const showWarn = (msg) => {
            if (!warn) return;
            warn.textContent = msg;
            warn.classList.remove('hidden');
            setTimeout(() => warn.classList.add('hidden'), 3000);
        };
        const hideWarn = () => warn?.classList.add('hidden');

        // Atualiza estado dos checkboxes e contador
        const updateState = () => {
            const checkedCount = boxes.filter(b => b.checked).length;

            if (counter) {
                counter.textContent = (Number.isFinite(max) && max > 0)
                    ? `Selecionados: ${checkedCount} de ${max}`
                    : `Selecionados: ${checkedCount}`;
            }
            hideWarn();

            if (!Number.isFinite(max) || max <= 0) return;

            const limitReached = checkedCount >= max;
            boxes.forEach(b => {
                const initiallyDisabled = b.dataset.initialDisabled === '1';
                if (b.checked) {
                    b.disabled = false;
                } else if (initiallyDisabled || limitReached) {
                    b.disabled = true;
                } else {
                    b.disabled = false;
                }
                const label = b.closest('label');
                if (label) {
                    const blocked = b.disabled && !b.checked;
                    label.style.opacity = blocked ? '0.5' : '1';
                    label.style.cursor  = blocked ? 'not-allowed' : 'pointer';
                }
            });
        };

        boxes.forEach(box => box.addEventListener('change', updateState));

        // Loading no botão de salvar
        if (form && btn) {
            form.addEventListener('submit', function(){
                btn.disabled = true;
                btn.classList.add('opacity-70', 'cursor-not-allowed');
                const txt = btn.querySelector('.btn-text');
                const spn = btn.querySelector('.btn-spin');
                if (txt) txt.textContent = 'Salvando...';
                if (spn) spn.style.display = 'inline-block';
            }, { once: true });
        }

        updateState();
    });
</script>
@endsection
