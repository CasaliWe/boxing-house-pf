@extends('layouts.app')

@section('title', 'Meus Treinos')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- Cabeçalho da página --}}
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Meus Treinos</h1>
            <p class="text-sm text-gray-400 mt-1">Suas aulas com foto, data e sequência aprendida</p>
        </div>
        @if($proximaSequencia)
            <div class="bg-blue-500/10 border border-blue-500/40 rounded-md px-4 py-2.5 max-w-md">
                <div class="text-xs text-blue-300 uppercase tracking-wider font-semibold mb-0.5">Próxima · Aula {{ $proximaNumero }}</div>
                <div class="text-sm text-blue-100">{{ $proximaSequencia->descricao }}</div>
            </div>
        @endif
    </div>

    {{-- Estatísticas rápidas --}}
    <div class="grid grid-cols-3 gap-4">
        @php
            $total = $treinos->count();
            $especiais = $treinos->where('especial', true)->count();
            $sequenciais = $total - $especiais;
        @endphp
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg p-5">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs text-gray-400 uppercase tracking-wider">Total</span>
                <div class="w-8 h-8 rounded-md bg-blue-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-white">{{ $total }}</div>
            <div class="text-xs text-gray-500 mt-1">Aulas registradas</div>
        </div>
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg p-5">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs text-gray-400 uppercase tracking-wider">Sequenciais</span>
                <div class="w-8 h-8 rounded-md bg-green-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-green-400">{{ $sequenciais }}</div>
            <div class="text-xs text-gray-500 mt-1">Da progressão</div>
        </div>
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg p-5">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs text-gray-400 uppercase tracking-wider">Especiais</span>
                <div class="w-8 h-8 rounded-md bg-purple-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-purple-400">{{ $especiais }}</div>
            <div class="text-xs text-gray-500 mt-1">Eventos / extras</div>
        </div>
    </div>

    {{-- Grid de treinos --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
            <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-white">Histórico de treinos</h3>
                <p class="text-xs text-gray-400">Ordenado do mais antigo ao mais recente</p>
            </div>
        </div>

        <div class="p-6">
            @if($treinos->isEmpty())
                <div class="text-center py-12 text-sm text-gray-500">
                    Você ainda não possui treinos registrados.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    @php $contadorPadrao = 0; @endphp
                    @foreach($treinos as $treino)
                        <div class="bg-gray-800/40 border border-gray-700 hover:border-blue-500/50 rounded-lg overflow-hidden transition-all">
                            <div class="aspect-video bg-gray-900 overflow-hidden">
                                <img src="{{ asset($treino->foto_path) }}" alt="Foto do treino" class="w-full h-full object-cover">
                            </div>
                            <div class="p-4 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-xs text-gray-500 uppercase tracking-wider mb-0.5">Data</div>
                                        <div class="text-sm font-medium text-white">{{ $treino->data->format('d/m/Y') }}</div>
                                    </div>
                                    @if($treino->especial)
                                        <span class="px-2 py-1 text-xs font-semibold rounded bg-purple-500/20 text-purple-300">Especial</span>
                                    @else
                                        @php $contadorPadrao++; @endphp
                                        <span class="px-2 py-1 text-xs font-semibold rounded bg-green-500/20 text-green-300">Aula {{ $contadorPadrao }}</span>
                                    @endif
                                </div>

                                @if(!$treino->especial)
                                    <div class="bg-gray-900/60 border border-gray-700 rounded-md p-3">
                                        <div class="text-xs text-gray-400 uppercase tracking-wider mb-1">Sequência aprendida</div>
                                        @if($treino->sequencia)
                                            <div class="flex items-center justify-between gap-3">
                                                <div class="text-sm text-gray-200 flex-1">{{ $treino->sequencia->descricao }}</div>
                                                @if($treino->video_path)
                                                    <img src="{{ asset($treino->video_path) }}" alt="Imagem" class="h-9 w-9 rounded object-cover border border-gray-700 shrink-0">
                                                @endif
                                            </div>
                                        @else
                                            <div class="text-sm text-gray-500">Sequência não configurada</div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Modal de vídeo das sequências --}}
<div id="modalVideoSequencia" class="fixed inset-0 z-50 hidden bg-black/70 backdrop-blur-sm">
    <div class="absolute inset-0 flex items-center justify-center p-4" onclick="closeVideoModal()">
        <video id="videoSequencia" controls class="block max-h-[90vh] max-w-[90vw] bg-black rounded-lg" onclick="event.stopPropagation();"></video>
    </div>
</div>

<script>
    // Abre o modal de vídeo da sequência
    function abrirModalVideo(src){
        const modal = document.getElementById('modalVideoSequencia');
        const v = document.getElementById('videoSequencia');
        v.src = src;
        modal.classList.remove('hidden');
    }
    // Fecha o modal e pausa o vídeo
    function closeVideoModal() {
        const modal = document.getElementById('modalVideoSequencia');
        const v = document.getElementById('videoSequencia');
        v.pause();
        modal.classList.add('hidden');
    }
</script>
@endsection
