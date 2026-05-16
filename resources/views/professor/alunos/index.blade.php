@extends('layouts.app')

@section('title', 'Alunos')

@section('content')
@php
    // Pacotes serializados para o JS
    $pacotesJs = $pacotes->map(fn($valor) => [
        'aulas_mes'  => (int) $valor->aulas_mes,
        'valor_aula' => (float) $valor->valor_aula,
    ])->values();
@endphp

<div class="max-w-7xl mx-auto space-y-6">

    {{-- Cabeçalho da página --}}
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Alunos</h1>
            <p class="text-sm text-gray-400 mt-1">Gerencie pacotes, saldos, horários e acessos</p>
        </div>
    </div>

    {{-- Filtros por status --}}
    <div class="flex flex-wrap items-center gap-2">
        @php
            $filterBtnClass = fn($active) => $active
                ? 'bg-blue-600 text-white border-transparent'
                : 'bg-gray-900/60 text-gray-300 border-gray-700 hover:bg-gray-800';
        @endphp
        <a href="{{ route('professor.alunos.index') }}"
           class="text-xs font-medium px-3 py-1.5 rounded-md border transition-colors {{ $filterBtnClass(!$status) }}">Todos</a>
        <a href="{{ route('professor.alunos.index', ['status' => 'ativo']) }}"
           class="text-xs font-medium px-3 py-1.5 rounded-md border transition-colors {{ $filterBtnClass($status==='ativo') }}">Ativos</a>
        <a href="{{ route('professor.alunos.index', ['status' => 'inativo']) }}"
           class="text-xs font-medium px-3 py-1.5 rounded-md border transition-colors {{ $filterBtnClass($status==='inativo') }}">Inativos</a>
        <a href="{{ route('professor.alunos.index', ['status' => 'pendente']) }}"
           class="text-xs font-medium px-3 py-1.5 rounded-md border transition-colors {{ $filterBtnClass($status==='pendente') }}">Pendentes</a>
    </div>

    {{-- Lista --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
            <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-white">Lista de alunos</h3>
                <p class="text-xs text-gray-400">{{ $alunos->total() ?? $alunos->count() }} {{ ($alunos->total() ?? $alunos->count()) === 1 ? 'aluno' : 'alunos' }}</p>
            </div>
        </div>

        <div class="p-6">
            @if($alunos->isEmpty())
                <div class="text-center py-12 text-sm text-gray-500">Nenhum aluno encontrado.</div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    @foreach($alunos as $u)
                        @php
                            $selecionadosIds = $u->horarios->pluck('id')->toArray();
                            $aulas          = (int) ($u->aulas_contratadas ?? (($u->plano_vezes ?? 0) * 4));
                            $restantes      = (int) ($u->aulas_restantes ?? 0);
                            $valorAula      = (float) ($u->valor_aula ?? 0);
                            $valorTotal     = (float) ($u->valor_total_aulas ?? ($aulas * $valorAula));
                            $totalPresencas = $u->treinos()->count();
                            $proximaNumero  = $u->treinos()->where('especial', false)->count() + 1;
                            $statusClass = match($u->status) {
                                'ativo'    => 'bg-green-500/20 text-green-300',
                                'pendente' => 'bg-yellow-500/20 text-yellow-300',
                                'inativo'  => 'bg-red-500/20 text-red-300',
                                default    => 'bg-gray-700 text-gray-300',
                            };
                        @endphp
                        <div class="bg-gray-800/40 border border-gray-700 hover:border-blue-500/40 rounded-lg p-4 flex flex-col gap-4 transition-all">
                            {{-- Cabeçalho do card --}}
                            <div class="flex items-start gap-3 pb-3 border-b border-gray-700">
                                <div class="w-10 h-10 rounded-full bg-linear-to-br from-blue-600 to-blue-800 flex items-center justify-center text-white text-sm font-semibold shrink-0">
                                    {{ mb_strtoupper(mb_substr($u->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="text-sm font-semibold text-white truncate">{{ $u->name }}</div>
                                    <div class="text-xs text-gray-500 truncate">{{ $u->email }}</div>
                                </div>
                                <span class="text-xs font-semibold px-2 py-1 rounded {{ $statusClass }} shrink-0">{{ ucfirst($u->status) }}</span>
                            </div>

                            {{-- Pacote e saldo --}}
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wider">Pacote</div>
                                    <div class="text-sm font-semibold text-blue-400 mt-0.5">{{ $aulas ?: '-' }} aulas</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs text-gray-500 uppercase tracking-wider">Saldo</div>
                                    <div class="mt-0.5">
                                        <span class="text-xs font-semibold px-2 py-0.5 rounded {{ $restantes > 0 ? 'bg-green-500/20 text-green-300' : 'bg-red-500/20 text-red-300' }}">{{ $restantes }} aula(s)</span>
                                    </div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wider">Por aula</div>
                                    <div class="text-sm text-gray-200 mt-0.5">R$ {{ number_format($valorAula, 2, ',', '.') }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs text-gray-500 uppercase tracking-wider">Total</div>
                                    <div class="text-sm text-gray-200 mt-0.5">R$ {{ number_format($valorTotal, 2, ',', '.') }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wider">Feitas</div>
                                    <div class="text-sm text-gray-200 mt-0.5">{{ $totalPresencas }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs text-gray-500 uppercase tracking-wider">Próxima</div>
                                    <div class="text-sm text-gray-200 mt-0.5">Aula {{ $proximaNumero }}</div>
                                </div>
                            </div>

                            {{-- Contato --}}
                            <div class="bg-gray-900/40 border border-gray-700 rounded-md p-3 space-y-1">
                                <div class="flex items-center gap-2 text-xs">
                                    <span class="text-gray-500 uppercase tracking-wider w-20">WhatsApp</span>
                                    <span class="text-gray-200">{{ $u->whatsapp ?: '-' }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-xs">
                                    <span class="text-gray-500 uppercase tracking-wider w-20">Instagram</span>
                                    <span class="text-gray-200">{{ $u->instagram ?: '-' }}</span>
                                </div>
                            </div>

                            {{-- Horários --}}
                            <div>
                                <div class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1.5">Horários</div>
                                @if($u->horarios->isEmpty())
                                    <div class="text-xs text-gray-500 italic">Nenhum horário selecionado</div>
                                @else
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach($u->horarios as $h)
                                            <span class="text-xs bg-gray-700/60 text-gray-200 rounded px-2 py-0.5">
                                                {{ $h->dia_semana_label }} · {{ \Illuminate\Support\Carbon::parse($h->hora_inicio)->format('H:i') }}
                                                @if(!$h->pivot->aprovado)<span class="text-yellow-300">(aguardando)</span>@endif
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            {{-- Ações --}}
                            <div class="flex flex-col gap-2 pt-1">
                                <button type="button"
                                        style="background-color: #2563eb; color: #ffffff;"
                                        onmouseover="this.style.backgroundColor='#1d4ed8'"
                                        onmouseout="this.style.backgroundColor='#2563eb'"
                                        class="w-full text-xs font-medium py-2 rounded-md transition-colors"
                                        data-user="{{ $u->id }}"
                                        data-aulas="{{ $aulas }}"
                                        data-restantes="{{ $restantes }}"
                                        data-valor-aula="{{ $valorAula }}"
                                        data-selecionados='@json($selecionadosIds)'
                                        onclick="abrirModalHorarios(this)">
                                    Atualizar pacote e horários
                                </button>
                                <div class="grid grid-cols-3 gap-2">
                                    <button type="button"
                                            class="w-full text-xs font-medium py-2 rounded-md border border-gray-700 text-gray-300 hover:bg-gray-800 transition-colors"
                                            data-detail-id="detail-{{ $u->id }}" onclick="abrirModalDetalhes(this)">
                                        Detalhes
                                    </button>
                                    <button type="button"
                                            style="background-color: #4f46e5; color: #ffffff;"
                                            onmouseover="this.style.backgroundColor='#4338ca'"
                                            onmouseout="this.style.backgroundColor='#4f46e5'"
                                            class="w-full text-xs font-medium py-2 rounded-md transition-colors"
                                            data-user="{{ $u->id }}" onclick="abrirModalSenha(this)">
                                        Senha
                                    </button>
                                    <form method="POST" action="{{ route('professor.alunos.destroy', $u) }}" onsubmit="return confirm('Confirma remover este aluno?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                style="background-color: #dc2626; color: #ffffff;"
                                                onmouseover="this.style.backgroundColor='#b91c1c'"
                                                onmouseout="this.style.backgroundColor='#dc2626'"
                                                class="w-full text-xs font-medium py-2 rounded-md transition-colors">
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- Detalhes ocultos usados pelo modal --}}
                            <div id="detail-{{ $u->id }}" class="hidden">
                                <div class="space-y-4">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                                        <div><div class="text-xs text-gray-500 uppercase tracking-wider">E-mail</div><div class="text-gray-200">{{ $u->email }}</div></div>
                                        <div><div class="text-xs text-gray-500 uppercase tracking-wider">WhatsApp</div><div class="text-gray-200">{{ $u->whatsapp ?: '-' }}</div></div>
                                        <div><div class="text-xs text-gray-500 uppercase tracking-wider">Instagram</div><div class="text-gray-200">{{ $u->instagram ?: '-' }}</div></div>
                                        <div><div class="text-xs text-gray-500 uppercase tracking-wider">Endereço</div><div class="text-gray-200">{{ $u->endereco ?: '-' }}</div></div>
                                        <div class="sm:col-span-2"><div class="text-xs text-gray-500 uppercase tracking-wider">Contato emergência</div><div class="text-gray-200">{{ $u->contato_emergencia_nome ?: '-' }} | {{ $u->contato_emergencia_whatsapp ?: '-' }}</div></div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm">
                                        <div><div class="text-xs text-gray-500 uppercase tracking-wider">Nascimento</div><div class="text-gray-200">{{ $u->data_nascimento ? \Illuminate\Support\Carbon::parse($u->data_nascimento)->format('d/m/Y') : '-' }}</div></div>
                                        <div><div class="text-xs text-gray-500 uppercase tracking-wider">Idade</div><div class="text-gray-200">{{ $u->idade ?: '-' }}</div></div>
                                        <div><div class="text-xs text-gray-500 uppercase tracking-wider">Peso</div><div class="text-gray-200">{{ $u->peso ?: '-' }}</div></div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                                        <div>
                                            <div class="text-xs text-gray-500 uppercase tracking-wider">Problema de saúde?</div>
                                            <div class="text-gray-200">{{ $u->saude_problema ? 'Sim' : 'Não' }}</div>
                                            @if($u->saude_problema)<div class="text-gray-400 mt-1 whitespace-pre-line text-xs">{{ $u->saude_descricao }}</div>@endif
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500 uppercase tracking-wider">Restrição médica/física?</div>
                                            <div class="text-gray-200">{{ $u->restricao_medica ? 'Sim' : 'Não' }}</div>
                                            @if($u->restricao_medica)<div class="text-gray-400 mt-1 whitespace-pre-line text-xs">{{ $u->restricao_descricao }}</div>@endif
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-500 uppercase tracking-wider mb-2">Objetivos</div>
                                        @php $objetivos = $u->objetivos ?? []; @endphp
                                        @if(empty($objetivos))
                                            <div class="text-sm text-gray-500">Nenhum</div>
                                        @else
                                            <div class="flex flex-wrap gap-1.5">
                                                @foreach($objetivos as $obj)
                                                    <span class="text-xs bg-gray-700/60 text-gray-200 rounded px-2 py-0.5">{{ $obj }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">{{ $alunos->links() }}</div>
            @endif
        </div>
    </div>
</div>

{{-- Modal de atualização --}}
<div id="modalHorarios" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/70 backdrop-blur-sm">
    <div class="absolute inset-0" onclick="fecharModalHorarios()"></div>
    <div class="relative max-w-3xl mx-auto my-12 bg-gray-900 border border-gray-700 rounded-xl shadow-2xl">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-800">
            <h2 class="text-lg font-semibold text-white">Atualizar pacote e horários</h2>
            <button class="text-gray-400 hover:text-white text-xl leading-none" onclick="fecharModalHorarios()">✕</button>
        </div>
        <form id="formModalHorarios" method="POST">
            @csrf
            @method('PUT')

            <div class="px-6 py-5 space-y-5">
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
                <button id="btnAtualizarHorarios" type="submit"
                        style="background-color: #2563eb; color: #ffffff;"
                        onmouseover="this.style.backgroundColor='#1d4ed8'"
                        onmouseout="this.style.backgroundColor='#2563eb'"
                        class="inline-flex items-center text-sm font-medium px-4 py-2 rounded-md transition-colors">
                    <span class="btn-spin inline-block align-middle w-3.5 h-3.5 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
                    <span class="btn-text">Atualizar</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const pacotes    = @json($pacotesJs);
    let modalForm, limitePlano = 0;
    const baseAction = '{{ url('/professor/alunos') }}';
    const moeda = (valor) => Number(valor || 0).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

    // Valor da aula para a quantidade escolhida
    function valorParaAulas(aulas, atual) {
        const ordenados = [...pacotes].sort((a, b) => a.aulas_mes - b.aulas_mes);
        const pacote    = ordenados.find(p => aulas <= p.aulas_mes) || ordenados[ordenados.length - 1];
        return Number(atual || 0) > 0 ? Number(atual) : Number(pacote?.valor_aula || 0);
    }

    // Abre o modal preenchendo os dados do aluno selecionado
    function abrirModalHorarios(btn) {
        const modal = document.getElementById('modalHorarios');
        modal.classList.remove('hidden');
        modalForm   = document.getElementById('formModalHorarios');
        const userId       = btn.dataset.user;
        const aulas        = parseInt(btn.dataset.aulas || '0', 10) || 1;
        const restantes    = parseInt(btn.dataset.restantes || '0', 10);
        const valorAula    = valorParaAulas(aulas, btn.dataset.valorAula);
        const selecionados = JSON.parse(btn.dataset.selecionados || '[]');

        modalForm.action = baseAction + '/' + userId + '/horarios';
        document.getElementById('modalAulas').value     = aulas;
        document.getElementById('modalRestantes').value = Math.min(restantes || aulas, aulas);
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

    // Recalcula totais e limites
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
        if (form) {
            form.addEventListener('submit', (e) => {
                const selecionados = Array.from(form.querySelectorAll('input[name="horarios[]"]:checked'));
                const info = document.getElementById('limiteInfo');
                if (limitePlano && selecionados.length > limitePlano) {
                    e.preventDefault();
                    info.classList.remove('text-gray-500');
                    info.classList.add('text-red-400');
                    info.textContent = `Você selecionou ${selecionados.length} e o limite é ${limitePlano}.`;
                    return false;
                }

                const btn = document.getElementById('btnAtualizarHorarios');
                btn.disabled = true;
                btn.classList.add('opacity-70','cursor-not-allowed');
                btn.querySelector('.btn-text').textContent = 'Atualizando...';
                btn.querySelector('.btn-spin').style.display = 'inline-block';
            });
        }
    });

    // Habilita/desabilita checkboxes com base no limite de horários
    function aplicarLimite(checks) {
        const marcados       = checks.filter(c => c.checked);
        const limiteAtingido = limitePlano && marcados.length >= limitePlano;

        checks.forEach(c => {
            const label = c.closest('label');
            const full  = c.dataset.full === '1';

            if (c.checked) {
                c.disabled = false;
            } else if (full || limiteAtingido) {
                c.disabled = true;
            } else {
                c.disabled = false;
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

    // Modal de detalhes do aluno (cria sob demanda)
    function abrirModalDetalhes(btn) {
        const tpl = document.getElementById(btn.getAttribute('data-detail-id'));
        if (!tpl) return;
        let modal = document.getElementById('modalDetalhes');
        if (!modal) {
            const wrapper = document.createElement('div');
            wrapper.id = 'modalDetalhes';
            wrapper.className = 'fixed inset-0 z-50 hidden overflow-y-auto bg-black/70 backdrop-blur-sm';
            wrapper.innerHTML = `
                <div class="absolute inset-0" data-close></div>
                <div class="relative max-w-2xl mx-auto my-12 bg-gray-900 border border-gray-700 rounded-xl shadow-2xl">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-800">
                        <h2 class="text-lg font-semibold text-white">Detalhes do aluno</h2>
                        <button class="text-gray-400 hover:text-white text-xl leading-none" data-close>✕</button>
                    </div>
                    <div id="detalhesConteudo" class="px-6 py-5"></div>
                </div>`;
            document.body.appendChild(wrapper);
            modal = wrapper;
            modal.addEventListener('click', (e) => { if (e.target.hasAttribute('data-close')) modal.classList.add('hidden'); });
        }
        modal.querySelector('#detalhesConteudo').innerHTML = tpl.innerHTML;
        modal.classList.remove('hidden');
    }

    // Modal de alteração de senha (cria sob demanda)
    function abrirModalSenha(btn) {
        const userId = btn.dataset.user;
        let modal = document.getElementById('modalSenha');
        if (!modal) {
            const wrapper = document.createElement('div');
            wrapper.id = 'modalSenha';
            wrapper.className = 'fixed inset-0 z-50 hidden overflow-y-auto bg-black/70 backdrop-blur-sm';
            wrapper.innerHTML = `
                <div class="absolute inset-0" data-close></div>
                <div class="relative max-w-md mx-auto my-12 bg-gray-900 border border-gray-700 rounded-xl shadow-2xl">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-800">
                        <h2 class="text-lg font-semibold text-white">Atualizar senha</h2>
                        <button class="text-gray-400 hover:text-white text-xl leading-none" data-close>✕</button>
                    </div>
                    <form id="formSenha" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="px-6 py-5 space-y-4">
                            <div>
                                <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Nova senha</label>
                                <input type="password" name="password" required
                                       class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Confirmar senha</label>
                                <input type="password" name="password_confirmation" required
                                       class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>
                        <div class="flex items-center justify-end gap-2 px-6 py-4 border-t border-gray-800">
                            <button type="button" data-close
                                    class="text-sm font-medium px-4 py-2 rounded-md border border-gray-700 text-gray-300 hover:bg-gray-800 transition-colors">
                                Cancelar
                            </button>
                            <button type="submit"
                                    style="background-color: #4f46e5; color: #ffffff;"
                                    onmouseover="this.style.backgroundColor='#4338ca'"
                                    onmouseout="this.style.backgroundColor='#4f46e5'"
                                    class="text-sm font-medium px-4 py-2 rounded-md transition-colors">
                                Atualizar
                            </button>
                        </div>
                    </form>
                </div>`;
            document.body.appendChild(wrapper);
            modal = wrapper;
            modal.addEventListener('click', (e) => { if (e.target.hasAttribute('data-close')) modal.classList.add('hidden'); });
        }
        modal.querySelector('#formSenha').action = `${baseAction}/${userId}/senha`;
        modal.classList.remove('hidden');
    }
</script>
@endsection
