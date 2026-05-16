@extends('layouts.app')

@section('title', 'Controle de Aulas')

@section('content')
@php
    // Pacotes para JS calcular o valor automaticamente
    $pacotesJs = $pacotes->map(fn($valor) => [
        'aulas_mes'  => (int) $valor->aulas_mes,
        'valor_aula' => (float) $valor->valor_aula,
    ])->values();
@endphp

<div class="max-w-7xl mx-auto space-y-6">

    {{-- Cabeçalho da página --}}
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Controle de Aulas</h1>
            <p class="text-sm text-gray-400 mt-1">Reative alunos inativos ou registre novos pacotes</p>
        </div>
        <div class="bg-red-500/10 border border-red-500/40 rounded-md px-4 py-2">
            <div class="text-xs text-red-300 uppercase tracking-wider font-semibold">Pendentes</div>
            <div class="text-2xl font-bold text-red-300">{{ $alunosInativos->total() ?? $alunosInativos->count() }}</div>
        </div>
    </div>

    {{-- Lista de alunos inativos/sem saldo --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
            <div class="w-9 h-9 rounded-md bg-red-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-white">Alunos sem saldo / inativos</h3>
                <p class="text-xs text-gray-400">Precisam de um novo pacote para voltar a treinar</p>
            </div>
        </div>

        <div class="p-6">
            @if($alunosInativos->isEmpty())
                <div class="text-center py-12 text-sm text-gray-500">
                    Nenhum aluno inativo ou sem saldo no momento.
                </div>
            @else
                <div class="space-y-3">
                    @foreach($alunosInativos as $aluno)
                        @php
                            $statusTexto = $aluno->status === 'inativo' ? 'Inativo' : 'Sem saldo';
                            $statusClasse = $aluno->status === 'inativo' ? 'bg-yellow-500/20 text-yellow-300' : 'bg-red-500/20 text-red-300';
                        @endphp
                        <div class="bg-gray-800/40 border border-gray-700 rounded-lg p-4 flex flex-col md:flex-row items-stretch md:items-center gap-4">
                            {{-- Dados do aluno --}}
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <div class="w-10 h-10 rounded-full bg-linear-to-br from-blue-600 to-blue-800 flex items-center justify-center text-white text-sm font-semibold shrink-0">
                                    {{ mb_strtoupper(mb_substr($aluno->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h3 class="text-sm font-semibold text-white truncate">{{ $aluno->name }}</h3>
                                        <span class="text-xs font-semibold px-2 py-0.5 rounded {{ $statusClasse }}">{{ $statusTexto }}</span>
                                    </div>
                                    <div class="text-xs text-gray-500 truncate">{{ $aluno->email }}</div>
                                </div>
                            </div>

                            {{-- Métricas --}}
                            <div class="grid grid-cols-3 gap-2 md:gap-4 text-center">
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wider">WhatsApp</div>
                                    <div class="text-xs text-gray-200 mt-0.5">{{ $aluno->whatsapp ?: '-' }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wider">Pacote</div>
                                    <div class="text-xs text-gray-200 mt-0.5">{{ $aluno->aulas_contratadas ?: 0 }} aula(s)</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wider">Saldo</div>
                                    <div class="text-xs font-semibold text-red-400 mt-0.5">{{ $aluno->aulas_restantes ?: 0 }}</div>
                                </div>
                            </div>

                            {{-- Ações --}}
                            <div class="flex flex-col sm:flex-row gap-2 shrink-0">
                                <button onclick="abrirModalReativar({{ $aluno->id }}, '{{ addslashes($aluno->name) }}', '{{ $aluno->status }}')"
                                        style="background-color: #16a34a; color: #ffffff;"
                                        onmouseover="this.style.backgroundColor='#15803d'"
                                        onmouseout="this.style.backgroundColor='#16a34a'"
                                        class="text-xs font-medium px-3 py-2 rounded-md transition-colors">
                                    {{ $aluno->status === 'inativo' ? 'Reativar' : 'Novo pacote' }}
                                </button>
                                @if($aluno->whatsapp)
                                    <a href="https://wa.me/55{{ preg_replace('/\D/', '', $aluno->whatsapp) }}?text=Ola {{ $aluno->name }}! Para continuar treinando, escolha um novo pacote de aulas e envie o comprovante."
                                       target="_blank"
                                       style="background-color: #2563eb; color: #ffffff;"
                                       onmouseover="this.style.backgroundColor='#1d4ed8'"
                                       onmouseout="this.style.backgroundColor='#2563eb'"
                                       class="text-xs font-medium px-3 py-2 rounded-md transition-colors text-center">
                                        WhatsApp
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">{{ $alunosInativos->links() }}</div>
            @endif
        </div>
    </div>
</div>

{{-- Modal de reativação / novo pacote --}}
<div id="modalReativar" class="fixed inset-0 z-50 hidden bg-black/70 backdrop-blur-sm">
    <div class="absolute inset-0 flex items-center justify-center p-4" onclick="fecharModal()">
        <div class="bg-gray-900 border border-gray-700 rounded-xl shadow-2xl w-full max-w-md" onclick="event.stopPropagation();">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-800">
                <h3 id="modalTitulo" class="text-lg font-semibold text-white">Novo pacote</h3>
                <button class="text-gray-400 hover:text-white text-xl leading-none" onclick="fecharModal()">✕</button>
            </div>
            <form id="formReativar" method="POST">
                @csrf
                <div class="px-6 py-5 space-y-4">
                    <p id="modalTexto" class="text-sm text-gray-300"></p>

                    <div>
                        <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Quantidade de aulas</label>
                        <input id="aulasContratadas" type="number" name="aulas_contratadas" min="1" max="100" value="{{ $pacotes->first()->aulas_mes ?? 4 }}"
                               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Valor por aula</label>
                        <input id="valorAula" type="text" inputmode="decimal" name="valor_aula"
                               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    </div>
                    <div class="bg-gray-800/60 border border-gray-700 rounded-md px-3 py-2.5 text-sm">
                        <span class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Total</span>
                        <span id="totalPacote" class="ml-2 text-green-400 font-semibold">-</span>
                    </div>
                </div>
                <div class="flex justify-end gap-2 px-6 py-4 border-t border-gray-800">
                    <button type="button" onclick="fecharModal()"
                            class="text-sm font-medium px-4 py-2 rounded-md border border-gray-700 text-gray-300 hover:bg-gray-800 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit"
                            style="background-color: #16a34a; color: #ffffff;"
                            onmouseover="this.style.backgroundColor='#15803d'"
                            onmouseout="this.style.backgroundColor='#16a34a'"
                            class="text-sm font-medium px-4 py-2 rounded-md transition-colors">
                        Salvar pacote
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Pacotes para cálculo dinâmico
    const pacotes = @json($pacotesJs);
    const moeda = (valor) => Number(valor || 0).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

    // Encontra o valor correspondente à quantidade de aulas
    function valorParaAulas(aulas) {
        const ordenados = [...pacotes].sort((a, b) => a.aulas_mes - b.aulas_mes);
        const pacote    = ordenados.find(p => aulas <= p.aulas_mes) || ordenados[ordenados.length - 1];
        return Number(pacote?.valor_aula || 0);
    }

    // Aceita vírgula ou ponto decimal
    const parseValor = (v) => Number(String(v || '0').replace(',', '.')) || 0;

    // Atualiza o total exibido
    function atualizarTotal() {
        const aulas = parseInt(document.getElementById('aulasContratadas').value || '0', 10);
        const valor = parseValor(document.getElementById('valorAula').value);
        document.getElementById('totalPacote').textContent = moeda(aulas * valor);
    }

    // Recalcula o valor da aula com base na quantidade
    function atualizarValorPorQuantidade() {
        const aulas = parseInt(document.getElementById('aulasContratadas').value || '0', 10);
        const valor = valorParaAulas(aulas);
        document.getElementById('valorAula').value = valor.toFixed(2);
        document.getElementById('totalPacote').textContent = moeda(aulas * valor);
    }

    // Abre o modal para o aluno selecionado
    function abrirModalReativar(id, nome, status) {
        const modal  = document.getElementById('modalReativar');
        const form   = document.getElementById('formReativar');
        const texto  = document.getElementById('modalTexto');
        const titulo = document.getElementById('modalTitulo');

        titulo.textContent = status === 'inativo' ? 'Reativar aluno' : 'Novo pacote';
        texto.textContent  = status === 'inativo'
            ? `Reativar ${nome} e registrar um novo pacote de aulas.`
            : `Registrar novo pacote para ${nome}.`;
        form.action = `/professor/mensalidades/${id}/reativar`;
        atualizarValorPorQuantidade();
        modal.classList.remove('hidden');
    }

    function fecharModal() {
        document.getElementById('modalReativar').classList.add('hidden');
    }

    document.getElementById('aulasContratadas')?.addEventListener('input', atualizarValorPorQuantidade);
    document.getElementById('valorAula')?.addEventListener('input', atualizarTotal);
</script>
@endsection
