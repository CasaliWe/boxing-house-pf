@extends('layouts.app')

@section('title', 'Fazer')

@section('content')
@php
    // Configurações das abas: cor base + ícone
    $abas = [
        \App\Models\Tarefa::STATUS_FAZER => [
            'label'      => 'Fazer',
            'cor_chip'   => 'bg-yellow-500/20 text-yellow-300',
            'cor_label'  => 'text-yellow-300',
        ],
        \App\Models\Tarefa::STATUS_FAZENDO => [
            'label'      => 'Fazendo',
            'cor_chip'   => 'bg-blue-500/20 text-blue-300',
            'cor_label'  => 'text-blue-300',
        ],
        \App\Models\Tarefa::STATUS_FEITO => [
            'label'      => 'Feito',
            'cor_chip'   => 'bg-green-500/20 text-green-300',
            'cor_label'  => 'text-green-300',
        ],
    ];
    $cfgAba = $abas[$aba];
@endphp

<div class="max-w-5xl mx-auto space-y-6">

    {{-- Cabeçalho da página --}}
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Fazer</h1>
            <p class="text-sm text-gray-400 mt-1">Quadro de tarefas — clique no card para avançar de status</p>
        </div>
    </div>

    {{-- Form de nova tarefa --}}
    <form method="POST" action="{{ route('professor.tarefas.store') }}" class="bg-gray-900/60 border border-gray-800 rounded-lg p-4">
        @csrf
        <div class="flex flex-col md:flex-row gap-2">
            <input type="text" name="titulo" required maxlength="255" placeholder="Nova tarefa..."
                   class="flex-1 bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <button type="submit"
                    style="background-color: #2563eb; color: #ffffff;"
                    onmouseover="this.style.backgroundColor='#1d4ed8'"
                    onmouseout="this.style.backgroundColor='#2563eb'"
                    class="inline-flex items-center justify-center gap-2 text-sm font-medium px-4 py-2 rounded-md transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Adicionar
            </button>
        </div>
        @error('titulo')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
    </form>

    {{-- Abas --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
        <div class="border-b border-gray-800 grid grid-cols-3">
            @foreach($abas as $status => $info)
                @php $ativa = $aba === $status; @endphp
                <a href="{{ route('professor.tarefas.index', ['aba' => $status]) }}"
                   class="flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-2 px-2 py-3 text-xs sm:text-sm font-medium border-b-2 transition-colors {{ $ativa ? 'border-blue-500 ' . $info['cor_label'] : 'border-transparent text-gray-400 hover:text-gray-200 hover:bg-gray-800/40' }}">
                    <span>{{ $info['label'] }}</span>
                    <span class="inline-block whitespace-nowrap text-[10px] sm:text-xs font-semibold px-1.5 sm:px-2 py-0.5 rounded-full {{ $info['cor_chip'] }}">
                        {{ $totais[$status] }}
                    </span>
                </a>
            @endforeach
        </div>

        {{-- Lista de tarefas da aba ativa --}}
        <div class="p-6">
            @if($tarefas->isEmpty())
                <div class="text-center py-12 text-sm text-gray-500">
                    @if($aba === \App\Models\Tarefa::STATUS_FAZER)
                        Nada para fazer agora. Adicione uma tarefa acima.
                    @elseif($aba === \App\Models\Tarefa::STATUS_FAZENDO)
                        Nenhuma tarefa em andamento.
                    @else
                        Nada feito ainda. Mãos à obra!
                    @endif
                </div>
            @else
                <div class="space-y-2">
                    @foreach($tarefas as $tarefa)
                        @php
                            $podeAvancar    = (bool) $tarefa->proximoStatus();
                            $podeRetroceder = (bool) $tarefa->statusAnterior();
                            $isFeito        = $tarefa->status === \App\Models\Tarefa::STATUS_FEITO;
                        @endphp
                        <div class="bg-gray-800/40 border border-gray-700 hover:border-blue-500/40 rounded-lg transition-all overflow-hidden"
                             id="tarefa-{{ $tarefa->id }}">

                            {{-- Linha principal: retroceder + corpo + ações --}}
                            <div class="flex items-stretch min-w-0">
                                {{-- Botão de retroceder (full-height na esquerda) --}}
                                @if($podeRetroceder)
                                    <form method="POST" action="{{ route('professor.tarefas.retroceder', $tarefa) }}" class="shrink-0 flex">
                                        @csrf
                                        <button type="submit" title="Voltar para o status anterior"
                                                class="px-2.5 sm:px-3 border-r border-gray-700 text-gray-400 hover:text-white hover:bg-gray-700/60 transition-colors flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                        </button>
                                    </form>
                                @endif

                                {{-- Corpo (click = avançar) --}}
                                @if($podeAvancar)
                                    <form method="POST" action="{{ route('professor.tarefas.avancar', $tarefa) }}" class="flex-1 min-w-0">
                                        @csrf
                                        <button type="submit" title="Avançar para o próximo status"
                                                class="text-left w-full block hover:bg-gray-700/30 transition-colors px-3 py-2.5">
                                            <div class="text-sm font-medium text-white break-words {{ $isFeito ? 'line-through text-gray-400' : '' }}">
                                                {{ $tarefa->titulo }}
                                            </div>
                                            @if($tarefa->descricao)
                                                <div class="text-xs text-gray-400 mt-1 whitespace-pre-line break-words">{{ $tarefa->descricao }}</div>
                                            @endif
                                            <div class="text-[10px] text-gray-500 uppercase tracking-wider mt-1.5">
                                                Atualizada {{ $tarefa->updated_at?->diffForHumans() }}
                                            </div>
                                        </button>
                                    </form>
                                @else
                                    <div class="flex-1 min-w-0 px-3 py-2.5">
                                        <div class="text-sm font-medium text-white break-words {{ $isFeito ? 'line-through text-gray-400' : '' }}">
                                            {{ $tarefa->titulo }}
                                        </div>
                                        @if($tarefa->descricao)
                                            <div class="text-xs text-gray-400 mt-1 whitespace-pre-line break-words">{{ $tarefa->descricao }}</div>
                                        @endif
                                        <div class="text-[10px] text-gray-500 uppercase tracking-wider mt-1.5">
                                            Atualizada {{ $tarefa->updated_at?->diffForHumans() }}
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- Barra de ações inferior --}}
                            <div class="flex items-center justify-between gap-2 px-3 py-2 border-t border-gray-700/60 bg-gray-900/40">
                                <span class="text-[10px] uppercase tracking-wider font-semibold {{ $cfgAba['cor_label'] }}">
                                    {{ $cfgAba['label'] }}
                                </span>
                                <div class="flex items-center gap-1.5">
                                    <button type="button" title="Editar"
                                            onclick="abrirModalEditar({{ $tarefa->id }}, '{{ addslashes($tarefa->titulo) }}', `{{ addslashes($tarefa->descricao ?? '') }}`)"
                                            class="text-xs font-medium px-2.5 py-1 rounded border border-gray-700 text-gray-300 hover:bg-gray-800 transition-colors inline-flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Editar
                                    </button>
                                    <form method="POST" action="{{ route('professor.tarefas.destroy', $tarefa) }}" onsubmit="return confirm('Excluir esta tarefa?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Excluir"
                                                style="background-color: #dc2626; color: #ffffff;"
                                                onmouseover="this.style.backgroundColor='#b91c1c'"
                                                onmouseout="this.style.backgroundColor='#dc2626'"
                                                class="text-xs font-medium px-2.5 py-1 rounded transition-colors inline-flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Legenda do fluxo --}}
            <div class="mt-6 pt-4 border-t border-gray-800 text-xs text-gray-500 flex flex-wrap items-center gap-2">
                <span>Fluxo:</span>
                <span class="text-yellow-300">Fazer</span>
                <span>→</span>
                <span class="text-blue-300">Fazendo</span>
                <span>→</span>
                <span class="text-green-300">Feito</span>
                <span class="ml-3 text-gray-600">Clique no card para avançar · ◀ para voltar</span>
            </div>
        </div>
    </div>
</div>

{{-- Modal de edição --}}
<div id="modalEditar" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 hidden">
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-gray-900 border border-gray-700 rounded-xl shadow-2xl w-full max-w-md">
            <div class="flex justify-between items-center px-6 py-4 border-b border-gray-800">
                <h3 class="text-lg font-semibold text-white">Editar tarefa</h3>
                <button onclick="fecharModalEditar()" class="text-gray-400 hover:text-white text-xl leading-none">✕</button>
            </div>
            <form id="formEditar" method="POST">
                @csrf
                @method('PUT')
                <div class="px-6 py-5 space-y-4">
                    <div>
                        <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Título</label>
                        <input type="text" id="edit-titulo" name="titulo" required maxlength="255"
                               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Descrição <span class="text-gray-500 normal-case font-normal">(opcional)</span></label>
                        <textarea id="edit-descricao" name="descricao" rows="4" maxlength="1000"
                                  class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"></textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-2 px-6 py-4 border-t border-gray-800">
                    <button type="button" onclick="fecharModalEditar()"
                            class="text-sm font-medium px-4 py-2 rounded-md border border-gray-700 text-gray-300 hover:bg-gray-800 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit"
                            style="background-color: #2563eb; color: #ffffff;"
                            onmouseover="this.style.backgroundColor='#1d4ed8'"
                            onmouseout="this.style.backgroundColor='#2563eb'"
                            class="text-sm font-medium px-4 py-2 rounded-md transition-colors">
                        Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Abre o modal preenchendo com os dados da tarefa
    function abrirModalEditar(id, titulo, descricao) {
        const form = document.getElementById('formEditar');
        form.action = `/professor/tarefas/${id}`;
        document.getElementById('edit-titulo').value    = titulo;
        document.getElementById('edit-descricao').value = descricao;
        document.getElementById('modalEditar').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    // Fecha o modal de edição
    function fecharModalEditar() {
        document.getElementById('modalEditar').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Permite fechar com ESC
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') fecharModalEditar();
    });
</script>
@endsection
