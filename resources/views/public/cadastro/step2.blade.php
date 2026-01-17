@extends('layouts.app')

@section('title', 'Cadastro - Etapa 2')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <div class="text-center">
        <h1 class="text-3xl font-bold text-blue-400">📅 Cadastro - Etapa 2</h1>
        <p class="text-gray-400">Selecione o plano e os horários desejados.</p>
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6 space-y-6">
        <form method="POST" action="{{ route('cadastro.step2.post') }}" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Plano (vezes por semana)</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($valores as $v)
                        @php
                            $aulasMes = max(($v->vezes_semana ?? 0) * 4, 1);
                            $porAula = ($v->valor ?? 0) / $aulasMes;
                        @endphp
                        <label class="border border-gray-600 rounded-lg p-4 bg-gray-800/40 flex items-center gap-3 cursor-pointer hover:border-blue-500">
                            <input type="radio"
                                   name="plano_vezes"
                                   value="{{ $v->vezes_semana }}"
                                   data-vezes="{{ $v->vezes_semana }}"
                                   {{ old('plano_vezes', $data['plano_vezes'] ?? '') == $v->vezes_semana ? 'checked' : '' }}
                                   class="text-blue-500">
                            <div>
                                <div class="text-white font-semibold">{{ $v->vezes_label }}</div>
                                <div class="text-gray-300">Valor: R$ {{ number_format($v->valor, 2, ',', '.') }}</div>
                                <div class="text-gray-400 text-xs mt-1">Por aula: R$ {{ number_format($porAula, 2, ',', '.') }}</div>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('plano_vezes')<div class="text-red-400 text-sm mt-2">{{ $message }}</div>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Selecione os horários (de acordo com o plano)</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($horarios as $h)
                        @php
                            $temVaga = $h->vagas_disponiveis > 0;
                        @endphp
                        <label class="border border-gray-600 rounded-lg p-4 bg-gray-800/40 flex items-center gap-3 {{ $temVaga ? 'cursor-pointer hover:border-blue-500' : 'cursor-not-allowed opacity-70' }}">
                            <input type="checkbox" name="horarios[]" value="{{ $h->id }}"
                                   {{ in_array($h->id, old('horarios', $data['horarios'] ?? [])) ? 'checked' : '' }}
                                   {{ $temVaga ? '' : 'disabled' }}
                                   class="text-blue-500">
                            <div>
                                <div class="text-white font-semibold flex items-center gap-2">
                                    <span>{{ $h->dia_semana_label }}</span>
                                    <span class="text-xs px-2 py-0.5 rounded {{ $temVaga ? 'bg-green-700 text-white' : 'bg-red-700 text-white' }}">
                                        {{ $temVaga ? ($h->vagas_disponiveis.' vaga(s)') : 'FULL' }}
                                    </span>
                                </div>
                                <div class="text-gray-300">{{ \Illuminate\Support\Carbon::parse($h->hora_inicio)->format('H:i') }} - {{ \Illuminate\Support\Carbon::parse($h->hora_fim)->format('H:i') }}</div>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('horarios')<div class="text-red-400 text-sm mt-2">{{ $message }}</div>@enderror
                <p class="text-xs text-gray-400 mt-2">Obs.: Horários marcados como FULL estão lotados e não podem ser selecionados.</p>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('cadastro.step1') }}" class="px-5 py-3 rounded-md border border-gray-600 text-gray-200 hover:bg-gray-700">Voltar</a>
                <button id="btnAvancar2" type="submit" class="px-5 py-3 rounded-md bg-blue-600 hover:bg-blue-700 text-white flex items-center gap-2">
                    <span class="btn-spin hidden w-4 h-4 border-2 border-white/60 border-t-transparent rounded-full animate-spin"></span>
                    <span class="btn-text">Avançar</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const radios = Array.from(document.querySelectorAll('input[name="plano_vezes"]'));
    const checks = Array.from(document.querySelectorAll('input[type="checkbox"][name="horarios[]"]'));

    function enforceLimit(){
        const sel = radios.find(r=>r.checked);
        const limite = sel ? parseInt(sel.dataset.vezes||'0') : 0;
        const marcados = checks.filter(c=>c.checked);
        const disponiveis = checks.filter(c=>!c.checked && !c.disabled);
        // quando atingiu o limite, desabilita os demais não marcados (marcando como desabilitado temporário)
        if(limite && marcados.length >= limite){
            disponiveis.forEach(c=>{ c.disabled = true; c.dataset.tempDisabled = '1'; c.closest('label')?.classList.add('opacity-70','cursor-not-allowed'); });
        } else {
            // reabilita apenas os que foram desabilitados por limite (tempDisabled)
            checks.forEach(c=>{
                const label = c.closest('label');
                if(!label) return;
                const isTemp = c.dataset.tempDisabled === '1';
                if(isTemp && !c.checked){ c.disabled = false; delete c.dataset.tempDisabled; label.classList.remove('opacity-70','cursor-not-allowed'); label.classList.add('cursor-pointer'); }
            });
        }
    }

    radios.forEach(r=>{ r.addEventListener('change', ()=>{ enforceLimit(); }); });
    checks.forEach(c=>{ c.addEventListener('change', ()=>{ enforceLimit(); }); });
    enforceLimit();

    const form = document.querySelector('form[action="{{ route('cadastro.step2.post') }}"]');
    if(form){
        form.addEventListener('submit', function(){
            const btn = form.querySelector('#btnAvancar2');
            if(btn){
                btn.disabled = true;
                btn.classList.add('opacity-70','cursor-not-allowed');
                const txt = btn.querySelector('.btn-text');
                const spn = btn.querySelector('.btn-spin');
                if(txt) txt.textContent = 'Carregando...';
                if(spn) spn.classList.remove('hidden');
            }
        });
    }
});
</script>
@endsection
