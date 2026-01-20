@extends('layouts.app')

@section('title', 'Vídeos')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="w-full sm:w-auto">
            <h1 class="text-2xl md:text-3xl font-bold text-blue-400">📹 Vídeos</h1>
            <p class="text-gray-400 text-sm md:text-base">Gerencie os módulos de vídeos para o aprendizado EAD dos alunos.</p>
        </div>
        <a href="{{ route('professor.videos.create') }}" class="bg-gradient-blue text-white px-5 py-3 rounded-lg font-medium w-full sm:w-auto text-center transition duration-150 hover:opacity-95 active:scale-95 focus:outline-none focus:ring-2 focus:ring-blue-500">+ Novo Módulo</a>
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        @if($modulos->isEmpty())
            <div class="text-center py-12 text-gray-300">
                <div class="text-6xl mb-4">🎬</div>
                <div class="text-xl font-semibold mb-2">Nenhum módulo criado ainda</div>
                <div class="text-gray-400">Crie seu primeiro módulo de vídeos para começar.</div>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($modulos as $modulo)
                    <div class="border border-gray-600 rounded-lg p-5 bg-gray-800/40 hover:bg-gray-800/60 transition-colors">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h3 class="text-white font-semibold text-lg">{{ $modulo->titulo }}</h3>
                                    @if(!$modulo->ativo)
                                        <span class="bg-red-600 text-white text-xs px-2 py-1 rounded">Inativo</span>
                                    @endif
                                </div>
                                
                                <div class="text-sm text-gray-400 mb-2">
                                    <span class="bg-blue-600/20 text-blue-300 px-2 py-1 rounded text-xs font-medium">
                                        {{ ucfirst($modulo->tema) }}
                                    </span>
                                </div>
                                
                                @if($modulo->descricao)
                                    <p class="text-gray-300 text-sm mb-3 line-clamp-2">{{ $modulo->descricao }}</p>
                                @endif
                                
                                <div class="flex items-center justify-between text-sm text-gray-400">
                                    <span>{{ $modulo->videos_count }} vídeo{{ $modulo->videos_count != 1 ? 's' : '' }}</span>
                                    <span>Aula {{ $modulo->aula_minima_acesso }}+</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col gap-2">
                            <a href="{{ route('professor.videos.show', $modulo) }}" class="block w-full h-10 px-3 py-2 rounded-md border border-gray-600 text-gray-200 hover:bg-gray-700 text-sm text-center transition duration-150 active:scale-95 focus:outline-none focus:ring-2 focus:ring-gray-500">Ver Vídeos</a>
                            
                            <div class="flex gap-2">
                                <a href="{{ route('professor.videos.edit', $modulo) }}" class="flex-1 h-10 px-3 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white text-sm text-center transition duration-150 active:scale-95 focus:outline-none focus:ring-2 focus:ring-blue-500 flex items-center justify-center">Editar</a>
                                
                                <form method="POST" action="{{ route('professor.videos.destroy', $modulo) }}" onsubmit="return confirm('Excluir este módulo e todos os seus vídeos?')" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button class="w-full h-10 px-3 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white text-sm transition duration-150 active:scale-95 focus:outline-none focus:ring-2 focus:ring-red-500">Excluir</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div>{{ $modulos->links() }}</div>
</div>
@endsection