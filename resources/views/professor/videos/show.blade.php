@extends('layouts.app')

@section('title', $modulo->titulo)

@section('content')
<div class="space-y-8">
    <!-- Header melhorado -->
    <div class="space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <a href="{{ route('professor.videos.index') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Voltar
            </a>
            <a href="{{ route('professor.videos.add-video', $modulo) }}" class="inline-flex items-center gap-2 bg-gradient-blue text-white px-4 py-2.5 rounded-lg font-medium transition duration-150 hover:opacity-95 active:scale-95 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-auto justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Adicionar Vídeo
            </a>
        </div>
        
        <div class="bg-gradient-card border border-gray-600 rounded-xl p-4 sm:p-6">
            <div class="space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white">{{ $modulo->titulo }}</h1>
                    @if(!$modulo->ativo)
                        <span class="bg-red-500 text-white text-sm px-3 py-1 rounded-full font-medium w-fit">Inativo</span>
                    @endif
                </div>
                
                <div class="flex flex-wrap items-center gap-2 sm:gap-4 text-sm">
                    <span class="bg-blue-600/20 text-blue-300 px-3 py-1 rounded-full font-medium">{{ ucfirst($modulo->tema) }}</span>
                    <span class="text-gray-400">Aula {{ $modulo->aula_minima_acesso }}+</span>
                    <span class="text-gray-400">{{ $modulo->videos->count() }} {{ $modulo->videos->count() == 1 ? 'vídeo' : 'vídeos' }}</span>
                </div>
                
                @if($modulo->descricao)
                    <p class="text-gray-300 text-sm sm:text-base">{{ $modulo->descricao }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        @if($modulo->videos->isEmpty())
            <div class="text-center py-16 text-gray-300">
                <div class="text-7xl mb-6">🎥</div>
                <div class="text-2xl font-bold mb-3 text-white">Nenhum vídeo adicionado ainda</div>
                <div class="text-gray-400 mb-6 max-w-md mx-auto">Adicione o primeiro vídeo para este módulo e comece a criar seu conteúdo educacional.</div>
                <a href="{{ route('professor.videos.add-video', $modulo) }}" class="inline-flex items-center gap-2 bg-gradient-blue text-white px-8 py-4 rounded-lg font-semibold transition duration-150 hover:opacity-95 hover:scale-105 shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Adicionar Primeiro Vídeo
                </a>
            </div>
        @else
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-white">Vídeos do Módulo</h2>
                    <span class="text-sm text-gray-400">{{ $modulo->videos->count() }} {{ $modulo->videos->count() == 1 ? 'vídeo' : 'vídeos' }}</span>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($modulo->videos as $video)
                        <div class="group bg-gray-800/50 border border-gray-700 rounded-xl p-4 hover:bg-gray-800/70 hover:border-gray-600 transition-all duration-200 hover:shadow-xl">
                            <!-- Video Thumbnail -->
                            <div class="aspect-video mb-4 overflow-hidden rounded-lg bg-gradient-to-br from-gray-700 to-gray-800 relative">
                                <video class="w-full h-full object-cover" preload="metadata">
                                    <source src="{{ asset('storage/'.$video->arquivo_path) }}" type="video/mp4">
                                </video>
                                <!-- Status Badge -->
                                <div class="absolute top-2 right-2">
                                    @if(!$video->ativo)
                                        <span class="bg-red-500/90 backdrop-blur-sm text-white text-xs px-2 py-1 rounded-full font-medium">Inativo</span>
                                    @else
                                        <span class="bg-green-500/90 backdrop-blur-sm text-white text-xs px-2 py-1 rounded-full font-medium">Ativo</span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Video Info -->
                            <div class="space-y-3">
                                <div>
                                    <h3 class="text-white font-semibold text-base line-clamp-2 leading-tight group-hover:text-blue-300 transition-colors">{{ $video->titulo }}</h3>
                                    @if($video->descricao)
                                        <p class="text-gray-400 text-sm mt-1 line-clamp-2">{{ $video->descricao }}</p>
                                    @endif
                                </div>
                                
                                <!-- Video Meta -->
                                <div class="flex items-center justify-end text-xs">
                                    <span class="text-gray-500">Ordem #{{ $video->ordem }}</span>
                                </div>
                                
                                <!-- Actions -->
                                <div class="flex gap-2 pt-2">
                                    <a href="{{ route('professor.videos.edit-video', [$modulo, $video]) }}" 
                                       class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2.5 px-3 rounded-lg transition-all duration-150 text-center hover:shadow-lg active:scale-95 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        Editar
                                    </a>
                                    
                                    <form method="POST" action="{{ route('professor.videos.destroy-video', [$modulo, $video]) }}" 
                                          onsubmit="return confirm('Tem certeza que deseja excluir este vídeo?')" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button class="w-full bg-red-600 hover:bg-red-700 text-white text-sm font-medium py-2.5 px-3 rounded-lg transition-all duration-150 hover:shadow-lg active:scale-95 focus:outline-none focus:ring-2 focus:ring-red-500">
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <div class="flex gap-4">
        <a href="{{ route('professor.videos.edit', $modulo) }}" class="px-6 py-3 rounded-lg border border-gray-600 text-gray-300 hover:bg-gray-700 transition duration-150">Editar Módulo</a>
    </div>
</div>
@endsection