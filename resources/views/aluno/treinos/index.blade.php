@extends('layouts.app')

@section('title', 'Meus Treinos')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-blue-400">🥊 Meus Treinos</h1>
            <p class="text-gray-400">Acompanhe suas aulas com foto, data e sequência aprendida.</p>
        </div>
        @if($proximaSequencia)
            <div class="px-4 py-3 rounded-lg border border-blue-600 bg-blue-800/30 text-blue-100">
                <span class="font-semibold">Próxima aula {{ $proximaNumero }}:</span>
                <span>{{ $proximaSequencia->descricao }}</span>
            </div>
        @endif
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        @if($treinos->isEmpty())
            <div class="text-center py-12 text-gray-300">Você ainda não possui treinos registrados.</div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @php $contadorPadrao = 0; @endphp
                @foreach($treinos as $treino)
                    <div class="border border-gray-600 rounded-lg p-5 bg-gray-800/40 hover:bg-gray-800/60 transition-colors">
                        <div class="aspect-video mb-4 overflow-hidden rounded-lg">
                            <img src="{{ asset('storage/'.$treino->foto_path) }}" alt="Foto do treino" class="w-full h-full object-cover">
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm text-gray-400 mb-1">Data do treino</div>
                                    <div class="text-white font-semibold">{{ $treino->data->format('d/m/Y') }}</div>
                                </div>
                                <div class="text-right">
                                    @if($treino->especial)
                                        <span class="inline-block px-3 py-1 text-xs rounded-full bg-purple-700 text-purple-100 border border-purple-600">✨ Aula especial</span>
                                    @else
                                        @php $contadorPadrao++; @endphp
                                        <span class="inline-block px-3 py-1 text-xs rounded-full bg-green-700 text-green-100 border border-green-600">🎯 Aula {{ $contadorPadrao }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            @if(!$treino->especial)
                                <div class="bg-gray-900 rounded-lg p-3">
                                    <div class="text-sm text-gray-400 mb-2">🎬 Sequência aprendida</div>
                                    @if($treino->sequencia)
                                        <div class="flex items-center justify-between gap-3">
                                            <div class="text-gray-200 text-sm">{{ $treino->sequencia->descricao }}</div>
                                            @if($treino->video_path)
                                                <button onclick="abrirModalVideo('{{ asset('storage/'.$treino->video_path) }}')" 
                                                        class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-medium transition-colors flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M8.5 5.5L15.5 10L8.5 14.5V5.5Z"/>
                                                    </svg>
                                                    Assistir
                                                </button>
                                            @endif
                                        </div>
                                    @else
                                        <div class="text-gray-400 text-sm">Sequência não configurada</div>
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

<!-- Modal de vídeo das sequências -->
<div id="modalVideoSequencia" class="fixed inset-0 z-50 hidden bg-black/70">
    <div class="absolute inset-0 flex items-center justify-center" onclick="closeVideoModal()">
        <video id="videoSequencia" controls class="block max-h-[90vh] max-w-[90vw] bg-black rounded" onclick="event.stopPropagation();"></video>
    </div>
</div>

<script>
function abrirModalVideo(src){
    const modal = document.getElementById('modalVideoSequencia');
    const v = document.getElementById('videoSequencia');
    v.src = src;
    modal.classList.remove('hidden');
}
function closeVideoModal() {
    const modal = document.getElementById('modalVideoSequencia');
    const v = document.getElementById('videoSequencia');
    v.pause();
    modal.classList.add('hidden');
}
</script>
@endsection
