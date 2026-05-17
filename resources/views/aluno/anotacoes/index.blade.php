@extends('layouts.app')

@section('title', 'Minhas Anotações')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- Cabeçalho da página --}}
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Minhas Anotações</h1>
            <p class="text-sm text-gray-400 mt-1">Organize pensamentos e registre informações sobre seus treinos</p>
        </div>
        <button onclick="abrirModalCriar()"
                style="background-color: #2563eb; color: #ffffff;"
                onmouseover="this.style.backgroundColor='#1d4ed8'"
                onmouseout="this.style.backgroundColor='#2563eb'"
                class="inline-flex items-center gap-2 text-sm font-medium px-4 py-2 rounded-md transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nova Anotação
        </button>
    </div>

    {{-- Filtro por data --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg p-4">
        <form method="GET" action="{{ route('aluno.anotacoes.index') }}" class="flex flex-col md:flex-row gap-3 items-stretch md:items-center">
            <label class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Filtrar por data</label>
            <input type="date" name="data_filtro" value="{{ request('data_filtro') }}"
                   class="bg-gray-800 border border-gray-700 rounded-md px-3 py-1.5 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <div class="flex gap-2">
                <button type="submit"
                        style="background-color: #2563eb; color: #ffffff;"
                        onmouseover="this.style.backgroundColor='#1d4ed8'"
                        onmouseout="this.style.backgroundColor='#2563eb'"
                        class="text-xs font-medium px-4 py-1.5 rounded-md transition-colors">
                    Filtrar
                </button>
                @if(request('data_filtro'))
                    <a href="{{ route('aluno.anotacoes.index') }}"
                       class="text-xs font-medium px-4 py-1.5 rounded-md border border-gray-700 text-gray-300 hover:bg-gray-800 transition-colors">
                        Limpar
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Lista de anotações --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
            <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-white">Suas anotações</h3>
                <p class="text-xs text-gray-400">{{ $anotacoes->total() ?? $anotacoes->count() }} {{ ($anotacoes->total() ?? $anotacoes->count()) === 1 ? 'registro' : 'registros' }}</p>
            </div>
        </div>

        <div class="p-6">
            @if($anotacoes->isEmpty())
                <div class="text-center py-12">
                    <h3 class="text-base font-semibold text-gray-300 mb-1">Nenhuma anotação encontrada</h3>
                    <p class="text-sm text-gray-500 mb-4">
                        @if(request('data_filtro'))
                            Não há anotações para a data selecionada.
                        @else
                            Comece criando sua primeira anotação para organizar seus pensamentos.
                        @endif
                    </p>
                    <button onclick="abrirModalCriar()"
                            style="background-color: #2563eb; color: #ffffff;"
                            onmouseover="this.style.backgroundColor='#1d4ed8'"
                            onmouseout="this.style.backgroundColor='#2563eb'"
                            class="inline-flex items-center gap-2 text-sm font-medium px-4 py-2 rounded-md transition-colors">
                        Criar primeira anotação
                    </button>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($anotacoes as $anotacao)
                        <div class="bg-gray-800/40 border border-gray-700 hover:border-blue-500/40 rounded-lg p-4 transition-all">
                            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-3">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-3 mb-2 flex-wrap">
                                        <h3 class="text-base font-semibold text-white">{{ $anotacao->titulo }}</h3>
                                        <span class="text-xs font-semibold px-2 py-0.5 rounded bg-blue-500/20 text-blue-300">
                                            {{ $anotacao->data_anotacao->format('d/m/Y') }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-300 leading-relaxed">
                                        {{ Str::limit($anotacao->conteudo, 200, '...') }}
                                    </div>
                                    @if(strlen($anotacao->conteudo) > 200)
                                        <button onclick="verAnotacao({{ $anotacao->id }}, '{{ addslashes($anotacao->titulo) }}', '{{ addslashes($anotacao->conteudo) }}', '{{ $anotacao->data_anotacao->format('Y-m-d') }}')"
                                                class="text-xs text-blue-400 hover:text-blue-300 mt-2">
                                            Ver mais...
                                        </button>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    <button onclick="editarAnotacao({{ $anotacao->id }}, '{{ addslashes($anotacao->titulo) }}', '{{ addslashes($anotacao->conteudo) }}', '{{ $anotacao->data_anotacao->format('Y-m-d') }}')"
                                            style="background-color: #ca8a04; color: #ffffff;"
                                            onmouseover="this.style.backgroundColor='#a16207'"
                                            onmouseout="this.style.backgroundColor='#ca8a04'"
                                            class="text-xs font-medium px-3 py-1.5 rounded transition-colors">
                                        Editar
                                    </button>
                                    <button onclick="confirmarExclusao({{ $anotacao->id }}, '{{ addslashes($anotacao->titulo) }}')"
                                            style="background-color: #dc2626; color: #ffffff;"
                                            onmouseover="this.style.backgroundColor='#b91c1c'"
                                            onmouseout="this.style.backgroundColor='#dc2626'"
                                            class="text-xs font-medium px-3 py-1.5 rounded transition-colors">
                                        Excluir
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($anotacoes->hasPages())
                    <div class="mt-6">{{ $anotacoes->links() }}</div>
                @endif
            @endif
        </div>
    </div>
</div>

{{-- Modal Criar/Editar --}}
<div id="modalAnotacao" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 hidden">
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-gray-900 border border-gray-700 rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-auto">
            <div class="flex justify-between items-center px-4 sm:px-6 py-4 border-b border-gray-800">
                <h3 id="tituloModal" class="text-lg font-semibold text-white">Nova Anotação</h3>
                <button onclick="fecharModal()" class="text-gray-400 hover:text-white text-xl leading-none">✕</button>
            </div>

            <form id="formAnotacao" method="POST" action="{{ route('aluno.anotacoes.store') }}">
                @csrf
                <input type="hidden" id="metodoPut" name="_method" value="">

                <div class="px-4 sm:px-6 py-5 space-y-4">
                    <div>
                        <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Título</label>
                        <input type="text" id="titulo" name="titulo" required
                               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Digite o título da anotação...">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Data</label>
                        <input type="date" id="data_anotacao" name="data_anotacao" required value="{{ date('Y-m-d') }}"
                               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Conteúdo</label>
                        <textarea id="conteudo" name="conteudo" required rows="8"
                                  class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                                  placeholder="Digite o conteúdo da sua anotação..."></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-2 px-4 sm:px-6 py-4 border-t border-gray-800">
                    <button type="button" onclick="fecharModal()"
                            class="text-sm font-medium px-4 py-2 rounded-md border border-gray-700 text-gray-300 hover:bg-gray-800 transition-colors">
                        Cancelar
                    </button>
                    <button id="btnSalvar" type="submit"
                            style="background-color: #16a34a; color: #ffffff;"
                            onmouseover="this.style.backgroundColor='#15803d'"
                            onmouseout="this.style.backgroundColor='#16a34a'"
                            class="text-sm font-medium px-4 py-2 rounded-md transition-colors">
                        <span class="btn-spin inline-block align-middle w-3.5 h-3.5 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
                        <span class="btn-text">Salvar Anotação</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal de confirmação de exclusão --}}
<div id="modalExclusao" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 hidden">
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-gray-900 border border-gray-700 rounded-xl shadow-2xl w-full max-w-md">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-800">
                <h3 class="text-lg font-semibold text-white">Confirmar exclusão</h3>
            </div>
            <div class="px-4 sm:px-6 py-5">
                <p class="text-sm text-gray-300">
                    Tem certeza que deseja excluir a anotação <span id="nomeExclusao" class="font-semibold text-white"></span>?
                </p>
                <p class="text-xs text-red-400 mt-2">Esta ação não pode ser desfeita.</p>
            </div>
            <div class="flex justify-end gap-2 px-4 sm:px-6 py-4 border-t border-gray-800">
                <button onclick="fecharModalExclusao()"
                        class="text-sm font-medium px-4 py-2 rounded-md border border-gray-700 text-gray-300 hover:bg-gray-800 transition-colors">
                    Cancelar
                </button>
                <form id="formExclusao" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            style="background-color: #dc2626; color: #ffffff;"
                            onmouseover="this.style.backgroundColor='#b91c1c'"
                            onmouseout="this.style.backgroundColor='#dc2626'"
                            class="text-sm font-medium px-4 py-2 rounded-md transition-colors">
                        Sim, excluir
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Variável de controle para saber se está editando
    let anotacaoEditando = null;

    // Abre o modal em modo "criar"
    function abrirModalCriar() {
        document.getElementById('tituloModal').textContent = 'Nova Anotação';
        document.getElementById('formAnotacao').action  = '{{ route('aluno.anotacoes.store') }}';
        document.getElementById('metodoPut').value      = '';
        document.getElementById('titulo').value         = '';
        document.getElementById('conteudo').value       = '';
        document.getElementById('data_anotacao').value  = '{{ date('Y-m-d') }}';
        document.getElementById('btnSalvar').querySelector('.btn-text').textContent = 'Salvar Anotação';
        anotacaoEditando = null;

        document.getElementById('modalAnotacao').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        document.getElementById('titulo').focus();
    }

    // Abre o modal em modo "editar"
    function editarAnotacao(id, titulo, conteudo, data) {
        document.getElementById('tituloModal').textContent = 'Editar Anotação';
        document.getElementById('formAnotacao').action  = `/aluno/anotacoes/${id}`;
        document.getElementById('metodoPut').value      = 'PUT';
        document.getElementById('titulo').value         = titulo;
        document.getElementById('conteudo').value       = conteudo;
        document.getElementById('data_anotacao').value  = data;
        document.getElementById('btnSalvar').querySelector('.btn-text').textContent = 'Atualizar Anotação';
        anotacaoEditando = id;

        document.getElementById('modalAnotacao').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        document.getElementById('titulo').focus();
    }

    // Reaproveita o modal de editar para visualizar uma anotação completa
    function verAnotacao(id, titulo, conteudo, data) {
        editarAnotacao(id, titulo, conteudo, data);
    }

    // Fecha o modal principal
    function fecharModal() {
        document.getElementById('modalAnotacao').classList.add('hidden');
        document.body.style.overflow = 'auto';
        anotacaoEditando = null;
    }

    // Abre o modal de confirmação de exclusão
    function confirmarExclusao(id, titulo) {
        document.getElementById('nomeExclusao').textContent = titulo;
        document.getElementById('formExclusao').action = `/aluno/anotacoes/${id}`;
        document.getElementById('modalExclusao').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    // Fecha o modal de exclusão
    function fecharModalExclusao() {
        document.getElementById('modalExclusao').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Loading no botão salvar + fechar com ESC
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('formAnotacao');
        const btn  = document.getElementById('btnSalvar');

        if (form && btn) {
            form.addEventListener('submit', function() {
                btn.disabled = true;
                btn.classList.add('opacity-70', 'cursor-not-allowed');
                const txt = btn.querySelector('.btn-text');
                const spn = btn.querySelector('.btn-spin');
                if (txt) txt.textContent = 'Salvando...';
                if (spn) spn.style.display = 'inline-block';
            }, { once: true });
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                fecharModal();
                fecharModalExclusao();
            }
        });
    });
</script>
@endsection
