@extends('layouts.app')

@section('title', 'Cadastro - Etapa 2')

@section('content')
@php
    $aulasEscolhidas = (int) old('aulas_mes', $data['aulas_mes'] ?? ($valores->first()->aulas_mes ?? 4));
    $pacotesJs = $valores->map(fn($valor) => [
        'aulas_mes' => (int) $valor->aulas_mes,
        'valor_aula' => (float) $valor->valor_aula,
    ])->values();
@endphp

<div class="max-w-4xl mx-auto space-y-8">
    <div class="text-center">
        <h1 class="text-3xl font-bold text-blue-400">Cadastro - Etapa 2</h1>
        <p class="text-gray-400">Escolha quantas aulas quer no mês e os horários fixos desejados.</p>
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6 space-y-6 mb-16">
        <form method="POST" action="{{ route('cadastro.step2.post') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                @foreach($valores as $valor)
                    <div class="border border-gray-600 rounded-lg p-4 bg-gray-800/40">
                        <div class="text-sm text-gray-400">Até {{ $valor->aulas_mes }} aulas/mês</div>
                        <div class="text-2xl font-semibold text-white mt-1">
                            R$ {{ number_format($valor->valor_aula, 2, ',', '.') }}
                            <span class="text-sm text-gray-400 font-normal">/aula</span>
                        </div>
                        <div class="text-xs text-gray-500 mt-2">
                            Total até R$ {{ number_format($valor->valor_total, 2, ',', '.') }}
                        </div>
                    </div>
                @endforeach
            </div>

            @if($valorExperimental)
                <div class="border border-blue-700 bg-blue-950/30 rounded-lg p-4 text-sm text-blue-100">
                    Aula experimental: <strong>R$ {{ number_format($valorExperimental->valor_aula, 2, ',', '.') }}</strong>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="aulas_mes" class="block text-sm font-medium text-gray-300 mb-2">Quantidade de aulas no mês</label>
                    <input
                        type="number"
                        id="aulas_mes"
                        name="aulas_mes"
                        min="1"
                        max="{{ $valores->max('aulas_mes') ?? 12 }}"
                        value="{{ $aulasEscolhidas }}"
                        class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                    @error('aulas_mes')<div class="text-red-400 text-sm mt-2">{{ $message }}</div>@enderror
                </div>

                <div class="bg-gray-900 border border-gray-700 rounded-lg p-4">
                    <div class="grid grid-cols-3 gap-3 text-center">
                        <div>
                            <div class="text-xs text-gray-500">Por aula</div>
                            <div id="resumoValorAula" class="text-blue-400 font-semibold">-</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">Total</div>
                            <div id="resumoValorTotal" class="text-green-400 font-semibold">-</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">Horários</div>
                            <div id="resumoHorarios" class="text-white font-semibold">-</div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Selecione seus horários fixos</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($horarios as $horario)
                        @php
                            $temVaga = $horario->vagas_disponiveis > 0;
                            $marcado = in_array($horario->id, old('horarios', $data['horarios'] ?? []));
                        @endphp
                        <label class="border border-gray-600 rounded-lg p-4 bg-gray-800/40 flex items-center gap-3 {{ $temVaga ? 'cursor-pointer hover:border-blue-500' : 'cursor-not-allowed opacity-70' }}">
                            <input
                                type="checkbox"
                                name="horarios[]"
                                value="{{ $horario->id }}"
                                {{ $marcado ? 'checked' : '' }}
                                {{ $temVaga ? '' : 'disabled' }}
                                data-full="{{ $temVaga ? '0' : '1' }}"
                                class="text-blue-500"
                            >
                            <div>
                                <div class="text-white font-semibold flex items-center gap-2">
                                    <span>{{ $horario->dia_semana_label }}</span>
                                    <span class="text-xs px-2 py-0.5 rounded {{ $temVaga ? 'bg-green-700 text-white' : 'bg-red-700 text-white' }}">
                                        {{ $temVaga ? ($horario->vagas_disponiveis.'/'.$horario->limite_alunos.' vaga(s)') : 'FULL' }}
                                    </span>
                                </div>
                                <div class="text-gray-300">{{ \Illuminate\Support\Carbon::parse($horario->hora_inicio)->format('H:i') }} - {{ \Illuminate\Support\Carbon::parse($horario->hora_fim)->format('H:i') }}</div>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('horarios')<div class="text-red-400 text-sm mt-2">{{ $message }}</div>@enderror
                <p id="horariosAjuda" class="text-xs text-gray-400 mt-2"></p>
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
    const pacotes = @json($pacotesJs);
    const aulasInput = document.getElementById('aulas_mes');
    const checks = Array.from(document.querySelectorAll('input[type="checkbox"][name="horarios[]"]'));
    const resumoValorAula = document.getElementById('resumoValorAula');
    const resumoValorTotal = document.getElementById('resumoValorTotal');
    const resumoHorarios = document.getElementById('resumoHorarios');
    const horariosAjuda = document.getElementById('horariosAjuda');

    const moeda = (valor) => Number(valor || 0).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

    function pacotePara(aulas) {
        const ordenados = [...pacotes].sort((a, b) => a.aulas_mes - b.aulas_mes);
        return ordenados.find(p => aulas <= p.aulas_mes) || ordenados[ordenados.length - 1] || null;
    }

    function atualizarResumo() {
        const aulas = Math.max(parseInt(aulasInput.value || '0', 10), 0);
        const pacote = pacotePara(aulas);
        const limiteHorarios = Math.max(1, Math.ceil(aulas / 4));
        const valorAula = pacote ? Number(pacote.valor_aula) : 0;

        resumoValorAula.textContent = moeda(valorAula);
        resumoValorTotal.textContent = moeda(valorAula * aulas);
        resumoHorarios.textContent = limiteHorarios;
        horariosAjuda.textContent = `Para ${aulas || 0} aula(s) no mês, selecione exatamente ${limiteHorarios} horário(s) fixo(s). Horários FULL ficam indisponíveis.`;

        aplicarLimite(limiteHorarios);
    }

    function aplicarLimite(limite) {
        const marcados = checks.filter(c => c.checked);
        const limiteAtingido = marcados.length >= limite;

        checks.forEach((checkbox) => {
            const label = checkbox.closest('label');
            const full = checkbox.dataset.full === '1';

            if (checkbox.checked) {
                checkbox.disabled = false;
            } else if (full || limiteAtingido) {
                checkbox.disabled = true;
            } else {
                checkbox.disabled = false;
            }

            if (label) {
                label.classList.toggle('opacity-70', checkbox.disabled && !checkbox.checked);
                label.classList.toggle('cursor-not-allowed', checkbox.disabled && !checkbox.checked);
                label.classList.toggle('cursor-pointer', !checkbox.disabled || checkbox.checked);
            }
        });
    }

    aulasInput?.addEventListener('input', atualizarResumo);
    checks.forEach(c => c.addEventListener('change', atualizarResumo));
    atualizarResumo();

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
