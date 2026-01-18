@extends('layouts.app')

@section('title', 'Meus Horários')

@section('content')
<div class="max-w-4xl mx-auto p-3 md:p-6">
    <h1 class="text-xl md:text-2xl font-semibold text-blue-400 mb-4">🗓️ Meus Horários</h1>
    @error('horarios')
        <div class="mb-4 px-4 py-3 bg-red-700 text-white rounded">{{ $message }}</div>
    @enderror

    <div class="bg-gray-800 border border-gray-700 rounded-xl p-4 md:p-6 space-y-4">
        <div class="bg-gray-900 rounded-lg p-4 mb-4">
            <div class="text-gray-400 text-sm mb-3 font-medium">📋 Horários selecionados atualmente</div>
            @if($user->horarios->isEmpty())
                <div class="text-gray-400 text-center py-2">Nenhum horário selecionado</div>
            @else
                <div class="space-y-2">
                    @foreach($user->horarios as $h)
                        <div class="flex items-center justify-between bg-gray-800 rounded-lg px-3 py-2">
                            <span class="text-gray-200 text-sm md:text-base">{{ $h->dia_semana_label }}</span>
                            <span class="text-blue-400 font-mono text-sm md:text-base">{{ \Illuminate\Support\Carbon::parse($h->hora_inicio)->format('H:i') }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <form method="POST" action="{{ route('aluno.horarios.update') }}" class="space-y-4" data-max="{{ (int)($user->plano_vezes ?? 0) }}">
            @csrf
            @method('PUT')
            @php $selecionados = $user->horarios->pluck('id')->all(); @endphp
            <div class="space-y-3 md:grid md:grid-cols-2 md:gap-3 md:space-y-0">
                @foreach($horarios as $h)
                    @php
                        $temVaga = $h->vagas_disponiveis > 0;
                        $jaSelecionado = in_array($h->id, $selecionados);
                    @endphp
                    <label class="block bg-gray-900 border {{ $jaSelecionado ? 'border-blue-500' : 'border-gray-700' }} rounded-lg p-4 hover:bg-gray-800 transition-colors cursor-pointer {{ (!$temVaga && !$jaSelecionado) ? 'opacity-60' : '' }}">
                        <div class="flex items-start gap-3">
                            <input type="checkbox" name="horarios[]" value="{{ $h->id }}" class="rounded mt-1 text-blue-600 focus:ring-blue-500"
                                   {{ $jaSelecionado ? 'checked' : '' }}
                                   {{ !$temVaga && !$jaSelecionado ? 'disabled' : '' }}
                                   data-initial-disabled="{{ (!$temVaga && !$jaSelecionado) ? '1' : '0' }}">
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                    <div class="text-gray-200 font-medium text-sm md:text-base">{{ $h->dia_semana_label }}</div>
                                    <div class="text-blue-400 font-mono text-sm md:text-base">{{ \Illuminate\Support\Carbon::parse($h->hora_inicio)->format('H:i') }}</div>
                                </div>
                                <div class="mt-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $temVaga ? 'bg-green-900 text-green-200 border border-green-700' : 'bg-red-900 text-red-200 border border-red-700' }}">
                                        {{ $temVaga ? '✓ '.$h->vagas_disponiveis.' vaga(s)' : '✕ LOTADO' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>
            <div class="bg-red-900/50 border border-red-700 rounded-lg p-3 text-red-200 text-sm hidden" data-limit-warning></div>
            
            <div class="bg-gray-900 rounded-lg p-4 space-y-2">
                <div class="text-sm text-gray-400" data-counter></div>
                <div class="text-sm text-gray-400">
                    <span class="inline-flex items-center gap-1">
                        <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                        Seu plano: <strong class="text-blue-400">{{ $user->plano_vezes ?: '-' }}x/semana</strong>
                    </span>
                </div>
            </div>
            
            <div class="pt-2">
                <button id="btnSalvarHorarios" type="submit" class="w-full md:w-auto px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                    <span class="btn-spin inline-block align-middle w-4 h-4 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
                    <span class="btn-text">Salvar horários</span>
                </button>
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
                const btn = document.getElementById('btnSalvarHorarios');
                
                const showWarn = (msg) => { 
                    if (warn) { 
                        warn.textContent = msg; 
                        warn.classList.remove('hidden'); 
                        setTimeout(() => warn.classList.add('hidden'), 3000);
                    } 
                };
                
                const hideWarn = () => { 
                    if (warn) { 
                        warn.classList.add('hidden'); 
                    } 
                };
                
                const updateState = () => {
                    const checkedCount = boxes.filter(b => b.checked).length;
                    
                    // Atualizar contador
                    if (counter) {
                        if (Number.isFinite(max) && max > 0) {
                            counter.textContent = `Selecionados: ${checkedCount} de ${max}`;
                        } else {
                            counter.textContent = `Selecionados: ${checkedCount}`;
                        }
                    }
                    
                    hideWarn();
                    
                    // Aplicar lógica de limite
                    if (Number.isFinite(max) && max > 0) {
                        const limitReached = checkedCount >= max;
                        
                        boxes.forEach(b => {
                            const initiallyDisabled = b.dataset.initialDisabled === '1';
                            
                            // Se está marcado, sempre habilitado (para permitir desmarcar)
                            if (b.checked) {
                                b.disabled = false;
                            } 
                            // Se não está marcado
                            else {
                                // Se estava inicialmente desabilitado (sem vaga), manter desabilitado
                                if (initiallyDisabled) {
                                    b.disabled = true;
                                }
                                // Se limite foi atingido, desabilitar
                                else if (limitReached) {
                                    b.disabled = true;
                                }
                                // Caso contrário, habilitar
                                else {
                                    b.disabled = false;
                                }
                            }
                            
                            // Atualizar aparência visual do label
                            const label = b.closest('label');
                            if (label) {
                                if (b.disabled && !b.checked) {
                                    label.style.opacity = '0.5';
                                    label.style.cursor = 'not-allowed';
                                } else {
                                    label.style.opacity = '1';
                                    label.style.cursor = 'pointer';
                                }
                            }
                        });
                    }
                };
                
                boxes.forEach(box => {
                    box.addEventListener('change', () => {
                        updateState();
                    });
                });
                
                // Loading no botão
                if (form && btn) {
                    form.addEventListener('submit', function(){
                        btn.disabled = true;
                        btn.classList.add('opacity-70', 'cursor-not-allowed');
                        const txt = btn.querySelector('.btn-text');
                        const spn = btn.querySelector('.btn-spin');
                        if(txt) txt.textContent = 'Salvando...';
                        if(spn) spn.style.display = 'inline-block';
                    }, { once: true });
                }
                
                updateState();
            }
        });
    </script>
@endsection
