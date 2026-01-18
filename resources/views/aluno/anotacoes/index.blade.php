@extends('layouts.app')

@section('title', 'Minhas Anotações')

@section('content')
<div class="max-w-6xl mx-auto p-3 md:p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <div>
            <h1 class="text-xl md:text-2xl font-semibold text-blue-400 mb-2">📝 Minhas Anotações</h1>
            <p class="text-gray-400 text-sm">Organize seus pensamentos e registre informações importantes sobre seus treinos.</p>
        </div>
        <button onclick="abrirModalCriar()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nova Anotação
        </button>
    </div>

    <!-- Filtro por data -->
    <div class="bg-gray-800 border border-gray-700 rounded-xl p-4 mb-6">
        <form method="GET" action="{{ route('aluno.anotacoes.index') }}" class="flex flex-col md:flex-row gap-3 items-center">
            <div class="flex items-center gap-3 w-full md:w-auto">
                <label class="text-gray-400 text-sm">📅 Filtrar por data:</label>
                <input type="date" name="data_filtro" value="{{ request('data_filtro') }}" 
                       class="bg-gray-900 border border-gray-600 rounded px-3 py-2 text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="flex gap-2 w-full md:w-auto">
                <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm transition-colors flex-1 md:flex-initial">
                    Filtrar
                </button>
                @if(request('data_filtro'))
                    <a href="{{ route('aluno.anotacoes.index') }}" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg text-sm transition-colors flex-1 md:flex-initial text-center">
                        Limpar
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Lista de anotações -->
    <div class="bg-gray-800 border border-gray-700 rounded-xl p-4 md:p-6">
        @if($anotacoes->isEmpty())
            <div class="text-center py-12">
                <div class="text-6xl mb-4">📝</div>
                <h3 class="text-xl font-semibold text-gray-400 mb-2">Nenhuma anotação encontrada</h3>
                <p class="text-gray-500 mb-4">
                    @if(request('data_filtro'))
                        Não há anotações para a data selecionada.
                    @else
                        Comece criando sua primeira anotação para organizar seus pensamentos.
                    @endif
                </p>
                <button onclick="abrirModalCriar()" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    Criar Primeira Anotação
                </button>
            </div>
        @else
            <div class="space-y-4">
                @foreach($anotacoes as $anotacao)
                    <div class="bg-gray-900 rounded-lg p-4 hover:bg-gray-800/70 transition-colors border border-gray-700">
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-white font-semibold text-lg truncate">{{ $anotacao->titulo }}</h3>
                                    <span class="text-xs px-2 py-1 bg-blue-600 text-blue-100 rounded-full">
                                        {{ $anotacao->data_anotacao->format('d/m/Y') }}
                                    </span>
                                </div>
                                <div class="text-gray-300 text-sm leading-relaxed">
                                    {{ Str::limit($anotacao->conteudo, 200, '...') }}
                                </div>
                                @if(strlen($anotacao->conteudo) > 200)
                                    <button onclick="verAnotacao({{ $anotacao->id }}, '{{ addslashes($anotacao->titulo) }}', '{{ addslashes($anotacao->conteudo) }}', '{{ $anotacao->data_anotacao->format('Y-m-d') }}')" 
                                            class="text-blue-400 hover:text-blue-300 text-sm mt-2">
                                        Ver mais...
                                    </button>
                                @endif
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <button onclick="editarAnotacao({{ $anotacao->id }}, '{{ addslashes($anotacao->titulo) }}', '{{ addslashes($anotacao->conteudo) }}', '{{ $anotacao->data_anotacao->format('Y-m-d') }}')" 
                                        class="px-3 py-1 bg-yellow-600 hover:bg-yellow-700 text-white rounded text-sm transition-colors">
                                    Editar
                                </button>
                                <button onclick="confirmarExclusao({{ $anotacao->id }}, '{{ addslashes($anotacao->titulo) }}')" 
                                        class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm transition-colors">
                                    Excluir
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginação -->
            @if($anotacoes->hasPages())
                <div class="mt-6">
                    {{ $anotacoes->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

<!-- Modal Criar/Editar -->
<div id="modalAnotacao" class="fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-4" style="display:none">
    <div class="bg-gray-800 rounded-xl p-6 w-full max-w-2xl max-h-[90vh] overflow-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 id="tituloModal" class="text-xl font-semibold text-white">Nova Anotação</h3>
            <button onclick="fecharModal()" class="text-gray-400 hover:text-white p-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <form id="formAnotacao" method="POST" action="{{ route('aluno.anotacoes.store') }}">
            @csrf
            <input type="hidden" id="metodoPut" name="_method" value="">
            
            <div class="space-y-4">
                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">📝 Título</label>
                    <input type="text" id="titulo" name="titulo" required 
                           class="w-full bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Digite o título da anotação...">
                </div>
                
                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">📅 Data</label>
                    <input type="date" id="data_anotacao" name="data_anotacao" required 
                           value="{{ date('Y-m-d') }}"
                           class="w-full bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">📄 Conteúdo</label>
                    <textarea id="conteudo" name="conteudo" required rows="8" 
                              class="w-full bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                              placeholder="Digite o conteúdo da sua anotação..."></textarea>
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row gap-3 mt-6">
                <button id="btnSalvar" type="submit" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors flex-1 md:flex-initial">
                    <span class="btn-spin inline-block align-middle w-4 h-4 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
                    <span class="btn-text">Salvar Anotação</span>
                </button>
                <button type="button" onclick="fecharModal()" class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-medium transition-colors flex-1 md:flex-initial">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div id="modalExclusao" class="fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-4" style="display:none">
    <div class="bg-gray-800 rounded-xl p-6 w-full max-w-md">
        <div class="flex items-center gap-3 mb-4">
            <div class="text-red-500 text-2xl">⚠️</div>
            <h3 class="text-xl font-semibold text-white">Confirmar Exclusão</h3>
        </div>
        
        <p class="text-gray-300 mb-6">
            Tem certeza que deseja excluir a anotação "<span id="nomeExclusao" class="font-semibold text-white"></span>"?
            <br><span class="text-sm text-red-400">Esta ação não pode ser desfeita.</span>
        </p>
        
        <div class="flex gap-3">
            <form id="formExclusao" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                    Sim, Excluir
                </button>
            </form>
            <button onclick="fecharModalExclusao()" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                Cancelar
            </button>
        </div>
    </div>
</div>

<script>
// Variáveis globais
let anotacaoEditando = null;

// Abrir modal para criar nova anotação
function abrirModalCriar() {
    document.getElementById('tituloModal').textContent = 'Nova Anotação';
    document.getElementById('formAnotacao').action = '{{ route('aluno.anotacoes.store') }}';
    document.getElementById('metodoPut').value = '';
    document.getElementById('titulo').value = '';
    document.getElementById('conteudo').value = '';
    document.getElementById('data_anotacao').value = '{{ date('Y-m-d') }}';
    document.getElementById('btnSalvar').querySelector('.btn-text').textContent = 'Salvar Anotação';
    anotacaoEditando = null;
    
    document.getElementById('modalAnotacao').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    document.getElementById('titulo').focus();
}

// Abrir modal para editar anotação
function editarAnotacao(id, titulo, conteudo, data) {
    document.getElementById('tituloModal').textContent = 'Editar Anotação';
    document.getElementById('formAnotacao').action = `/aluno/anotacoes/${id}`;
    document.getElementById('metodoPut').value = 'PUT';
    document.getElementById('titulo').value = titulo;
    document.getElementById('conteudo').value = conteudo;
    document.getElementById('data_anotacao').value = data;
    document.getElementById('btnSalvar').querySelector('.btn-text').textContent = 'Atualizar Anotação';
    anotacaoEditando = id;
    
    document.getElementById('modalAnotacao').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    document.getElementById('titulo').focus();
}

// Ver anotação completa (mesmo modal do editar, mas somente leitura)
function verAnotacao(id, titulo, conteudo, data) {
    editarAnotacao(id, titulo, conteudo, data);
}

// Fechar modal
function fecharModal() {
    document.getElementById('modalAnotacao').style.display = 'none';
    document.body.style.overflow = 'auto';
    anotacaoEditando = null;
}

// Confirmar exclusão
function confirmarExclusao(id, titulo) {
    document.getElementById('nomeExclusao').textContent = titulo;
    document.getElementById('formExclusao').action = `/aluno/anotacoes/${id}`;
    document.getElementById('modalExclusao').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

// Fechar modal de exclusão
function fecharModalExclusao() {
    document.getElementById('modalExclusao').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Loading no botão salvar
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formAnotacao');
    const btn = document.getElementById('btnSalvar');
    
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
    
    // Fechar modal com ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            fecharModal();
            fecharModalExclusao();
        }
    });
});
</script>
@endsection