@extends('layouts.app')

@section('title', 'Aprovações')

@section('content')
@php
    // Pacotes em formato JS para o cálculo dinâmico de valores
    $pacotesJs = $pacotes->map(fn($valor) => [
        'aulas_mes'  => (int) $valor->aulas_mes,
        'valor_aula' => (float) $valor->valor_aula,
    ])->values();
@endphp

<div class="max-w-7xl mx-auto space-y-6">

    {{-- Cabeçalho da página --}}
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Aprovações de cadastro</h1>
            <p class="text-sm text-gray-400 mt-1">Revise pacote, saldo e horários antes de aprovar</p>
        </div>
        <div class="bg-purple-500/10 border border-purple-500/40 rounded-md px-4 py-2">
            <div class="text-xs text-purple-300 uppercase tracking-wider font-semibold">Pendentes</div>
            <div class="text-2xl font-bold text-purple-300">{{ $pendentes->total() ?? $pendentes->count() }}</div>
        </div>
    </div>

    {{-- Lista de pendentes --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
            <div class="w-9 h-9 rounded-md bg-purple-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-white">Aguardando aprovação</h3>
                <p class="text-xs text-gray-400">Cadastros que ainda não foram processados</p>
            </div>
        </div>

        <div class="p-6">
            @if($pendentes->isEmpty())
                <div class="text-center py-12 text-sm text-gray-500">Nenhum cadastro pendente no momento.</div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    @foreach($pendentes as $u)
                        @php
                            $selecionadosIds = $u->horarios->pluck('id')->toArray();
                            $aulas           = (int) ($u->aulas_contratadas ?? (($u->plano_vezes ?? 0) * 4));
                            $restantes       = (int) ($u->aulas_restantes ?? $aulas);
                            $valorAula       = (float) ($u->valor_aula ?? 0);
                            $valorTotal      = (float) ($u->valor_total_aulas ?? ($aulas * $valorAula));
                        @endphp
                        <div class="bg-gray-800/40 border border-gray-700 hover:border-blue-500/40 rounded-lg p-4 flex flex-col gap-4 transition-all">
                            {{-- Cabeçalho do card --}}
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-full bg-linear-to-br from-blue-600 to-blue-800 flex items-center justify-center text-white text-sm font-semibold shrink-0">
                                    {{ mb_strtoupper(mb_substr($u->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="text-sm font-semibold text-white truncate">{{ $u->name }}</div>
                                    <div class="text-xs text-gray-500 truncate">{{ $u->email }}</div>
                                </div>
                                <span class="text-xs font-semibold px-2 py-1 rounded bg-blue-500/20 text-blue-300 shrink-0">
                                    {{ $aulas ?: '-' }} aulas
                                </span>
                            </div>

                            {{-- Dados em grade --}}
                            <div class="grid grid-cols-2 gap-3 text-sm bg-gray-900/40 border border-gray-700 rounded-md p-3">
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wider">WhatsApp</div>
                                    <div class="text-gray-200 wrap-break-word">{{ $u->whatsapp }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wider">Saldo inicial</div>
                                    <div class="text-green-400 font-semibold">{{ $restantes }} aula(s)</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wider">Valor / aula</div>
                                    <div class="text-gray-200">R$ {{ number_format($valorAula, 2, ',', '.') }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wider">Total</div>
                                    <div class="text-gray-200">R$ {{ number_format($valorTotal, 2, ',', '.') }}</div>
                                </div>
                            </div>

                            {{-- Horários escolhidos --}}
                            <div>
                                <div class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-2">Horários selecionados</div>
                                @if($u->horarios->isEmpty())
                                    <div class="text-xs text-gray-500">Nenhum selecionado</div>
                                @else
                                    <ul class="space-y-1">
                                        @foreach($u->horarios as $h)
                                            @php $temVaga = $h->vagas_disponiveis > 0; @endphp
                                            <li class="flex items-center justify-between gap-2 text-sm">
                                                <span class="text-gray-200">{{ $h->dia_semana_label }} · {{ \Illuminate\Support\Carbon::parse($h->hora_inicio)->format('H:i') }}</span>
                                                <span class="text-xs font-semibold px-2 py-0.5 rounded {{ $temVaga ? 'bg-green-500/20 text-green-300' : 'bg-red-500/20 text-red-300' }}">
                                                    {{ $temVaga ? 'Vaga' : 'FULL' }}
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>

                            {{-- Ações --}}
                            <div class="flex items-center gap-2 pt-1">
                                <form method="POST" action="{{ route('professor.aprovacoes.aprovar', $u) }}" class="flex-1" onsubmit="btnLoading(this)">
                                    @csrf
                                    <button type="submit"
                                            style="background-color: #16a34a; color: #ffffff;"
                                            onmouseover="this.style.backgroundColor='#15803d'"
                                            onmouseout="this.style.backgroundColor='#16a34a'"
                                            class="w-full text-sm font-medium py-2 rounded-md transition-colors inline-flex items-center justify-center gap-2">
                                        <span class="btn-spin hidden w-3.5 h-3.5 border-2 border-white/60 border-t-transparent rounded-full animate-spin"></span>
                                        <span class="btn-text">Aprovar</span>
                                    </button>
                                </form>
                                <button type="button"
                                        style="background-color: #2563eb; color: #ffffff;"
                                        onmouseover="this.style.backgroundColor='#1d4ed8'"
                                        onmouseout="this.style.backgroundColor='#2563eb'"
                                        class="flex-1 text-sm font-medium py-2 rounded-md transition-colors"
                                        data-user="{{ $u->id }}"
                                        data-aulas="{{ $aulas }}"
                                        data-restantes="{{ $restantes }}"
                                        data-valor-aula="{{ $valorAula }}"
                                        data-selecionados='@json($selecionadosIds)'
                                        onclick="abrirModalHorarios(this)">
                                    Atualizar
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">{{ $pendentes->links() }}</div>
            @endif
        </div>
    </div>
</div>

{{-- Modal de atualização --}}
<div id="modalHorarios" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/70 backdrop-blur-sm">
    <div class="absolute inset-0" onclick="fecharModalHorarios()"></div>
    <div class="relative max-w-3xl mx-auto my-12 bg-gray-900 border border-gray-700 rounded-xl shadow-2xl">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-800">
            <h2 class="text-lg font-semibold text-white">Atualizar cadastro do aluno</h2>
            <button class="text-gray-400 hover:text-white text-xl leading-none" onclick="fecharModalHorarios()">✕</button>
        </div>
        <form id="formModalHorarios" method="POST">
            @csrf
            @method('PUT')

            <div class="px-6 py-5 space-y-5">
                {{-- Campos numéricos --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Aulas no mês</label>
                        <input id="modalAulas" name="aulas_contratadas" type="number" min="1" max="100"
                               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Restantes</label>
                        <input id="modalRestantes" name="aulas_restantes" type="number" min="0" max="100"
                               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Valor / aula</label>
                        <input id="modalValorAula" name="valor_aula" type="number" min="0" step="0.01"
                               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Total</label>
                        <div id="modalTotal" class="w-full bg-gray-800/60 border border-gray-700 rounded-md px-3 py-2 text-sm font-semibold text-green-400">-</div>
                    </div>
                </div>

                {{-- Horários --}}
                <div>
                    <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-2">Horários disponíveis</div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-72 overflow-y-auto pr-1">
                        @foreach($horarios as $h)
                            @php $temVaga = $h->vagas_disponiveis > 0; @endphp
                            <label class="border border-gray-700 rounded-md p-3 bg-gray-800/40 flex items-center gap-3 {{ $temVaga ? 'cursor-pointer hover:border-blue-500/60' : 'cursor-not-allowed opacity-60' }}">
                                <input type="checkbox" name="horarios[]" value="{{ $h->id }}" {{ $temVaga ? '' : 'disabled' }} data-full="{{ $temVaga ? '0' : '1' }}" class="rounded bg-gray-900 border-gray-700 text-blue-600 focus:ring-blue-500">
                                <div class="flex-1 min-w-0">
                                    <div class="text-sm font-semibold text-white flex items-center gap-2 flex-wrap">
                                        <span>{{ $h->dia_semana_label }}</span>
                                        <span class="text-xs font-semibold px-2 py-0.5 rounded {{ $temVaga ? 'bg-green-500/20 text-green-300' : 'bg-red-500/20 text-red-300' }}">
                                            {{ $temVaga ? ($h->vagas_disponiveis.' vaga(s)') : 'FULL' }}
                                        </span>
                                    </div>
                                    <div class="text-xs text-gray-400">{{ \Illuminate\Support\Carbon::parse($h->hora_inicio)->format('H:i') }} - {{ \Illuminate\Support\Carbon::parse($h->hora_fim)->format('H:i') }}</div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    <p id="limiteInfo" class="text-xs text-gray-500 mt-2">Selecione até <span id="limiteNum">0</span> horário(s).</p>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 px-6 py-4 border-t border-gray-800">
                <button type="button" onclick="fecharModalHorarios()"
                        class="text-sm font-medium px-4 py-2 rounded-md border border-gray-700 text-gray-300 hover:bg-gray-800 transition-colors">
                    Cancelar
                </button>
                <button type="submit"
                        style="background-color: #2563eb; color: #ffffff;"
                        onmouseover="this.style.backgroundColor='#1d4ed8'"
                        onmouseout="this.style.backgroundColor='#2563eb'"
                        class="text-sm font-medium px-4 py-2 rounded-md transition-colors">
                    Atualizar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Pacotes para cálculo dinâmico de valores
    const pacotes = @json($pacotesJs);
    let modalForm, limitePlano = 0;
    const baseAction = '{{ url('/professor/alunos') }}';
    const moeda = (valor) => Number(valor || 0).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

    // Retorna o valor da aula correspondente à quantidade de aulas escolhida
    function valorParaAulas(aulas, atual) {
        const ordenados = [...pacotes].sort((a, b) => a.aulas_mes - b.aulas_mes);
        const pacote    = ordenados.find(p => aulas <= p.aulas_mes) || ordenados[ordenados.length - 1];
        return Number(atual || 0) > 0 ? Number(atual) : Number(pacote?.valor_aula || 0);
    }

    // Abre o modal preenchendo os campos com os dados do aluno
    function abrirModalHorarios(btn) {
        const modal = document.getElementById('modalHorarios');
        modal.classList.remove('hidden');
        modalForm   = document.getElementById('formModalHorarios');
        const userId       = btn.dataset.user;
        const aulas        = parseInt(btn.dataset.aulas || '0', 10) || 1;
        const restantes    = parseInt(btn.dataset.restantes || '0', 10) || aulas;
        const valorAula    = valorParaAulas(aulas, btn.dataset.valorAula);
        const selecionados = JSON.parse(btn.dataset.selecionados || '[]');

        modalForm.action = baseAction + '/' + userId + '/horarios';
        document.getElementById('modalAulas').value     = aulas;
        document.getElementById('modalRestantes').value = restantes;
        document.getElementById('modalValorAula').value = valorAula.toFixed(2);

        const checks = Array.from(modalForm.querySelectorAll('input[type="checkbox"][name="horarios[]"]'));
        checks.forEach(c => {
            const val = parseInt(c.value, 10);
            c.checked = selecionados.includes(val);
            c.dataset.tempDisabled = '';
            if (c.checked && c.disabled) {
                c.disabled = false;
                c.dataset.fullSelected = '1';
            }
        });

        atualizarPacoteModal(false);
        checks.forEach(c => { c.onchange = () => aplicarLimite(checks); });
    }

    function fecharModalHorarios() {
        document.getElementById('modalHorarios').classList.add('hidden');
    }

    // Recalcula totais e limites a partir da quantidade de aulas
    function atualizarPacoteModal(recalcularValor = true) {
        const aulasInput     = document.getElementById('modalAulas');
        const restantesInput = document.getElementById('modalRestantes');
        const valorInput     = document.getElementById('modalValorAula');
        const aulas          = Math.max(parseInt(aulasInput.value || '1', 10), 1);

        limitePlano = Math.max(1, Math.ceil(aulas / 4));
        document.getElementById('limiteNum').textContent = limitePlano;

        if (recalcularValor) {
            valorInput.value = valorParaAulas(aulas, 0).toFixed(2);
        }
        if (parseInt(restantesInput.value || '0', 10) > aulas) {
            restantesInput.value = aulas;
        }

        document.getElementById('modalTotal').textContent = moeda(aulas * Number(valorInput.value || 0));
        aplicarLimite(Array.from(document.getElementById('formModalHorarios').querySelectorAll('input[type="checkbox"][name="horarios[]"]')));
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('modalAulas')?.addEventListener('input', () => atualizarPacoteModal(true));
        document.getElementById('modalValorAula')?.addEventListener('input', () => atualizarPacoteModal(false));

        const form = document.getElementById('formModalHorarios');
        if (!form) return;
        form.addEventListener('submit', (e) => {
            const selecionados = Array.from(form.querySelectorAll('input[name="horarios[]"]:checked'));
            const info = document.getElementById('limiteInfo');
            let erro = '';
            if (limitePlano && selecionados.length > limitePlano) {
                erro = `Você selecionou ${selecionados.length} e o limite é ${limitePlano}.`;
            } else if (selecionados.length === 0) {
                erro = 'Selecione ao menos 1 horário.';
            }
            if (erro) {
                e.preventDefault();
                info.classList.remove('text-gray-500');
                info.classList.add('text-red-400');
                info.textContent = erro;
                return false;
            }
            info.classList.remove('text-red-400');
            info.classList.add('text-gray-500');
        });
    });

    // Habilita/desabilita os checkboxes conforme limite de horários
    function aplicarLimite(checks) {
        const marcados        = checks.filter(c => c.checked);
        const limiteAtingido  = limitePlano && marcados.length >= limitePlano;

        checks.forEach(c => {
            const label = c.closest('label');
            const full  = c.dataset.full === '1';

            if (c.checked) {
                c.disabled = false;
            } else if (full || limiteAtingido) {
                c.disabled = true;
                c.dataset.tempDisabled = limiteAtingido && !full ? '1' : '';
            } else {
                c.disabled = false;
                c.dataset.tempDisabled = '';
            }

            if (!c.checked && c.dataset.fullSelected === '1') {
                c.disabled = true;
            }

            if (label) {
                label.classList.toggle('opacity-60', c.disabled && !c.checked);
                label.classList.toggle('cursor-not-allowed', c.disabled && !c.checked);
                label.classList.toggle('cursor-pointer', !c.disabled || c.checked);
            }
        });
    }

    // Coloca o botão em loading quando o formulário é enviado
    function btnLoading(form) {
        if (!form) return;
        const btn = form.querySelector('button[type="submit"]');
        if (!btn) return;
        const txt = btn.querySelector('.btn-text');
        const spn = btn.querySelector('.btn-spin');
        btn.disabled = true;
        btn.classList.add('opacity-70','cursor-not-allowed');
        if (txt) txt.textContent = 'Carregando...';
        if (spn) spn.classList.remove('hidden');
    }
</script>
@endsection
