@extends('layouts.app')

@section('title', 'Ideias de Exercícios')

@section('content')
<div class="space-y-8">
    <!-- Cabeçalho -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="w-full sm:w-auto">
            <h1 class="text-2xl md:text-3xl font-bold text-blue-400">💡 Ideias de Exercícios</h1>
            <p class="text-gray-400 text-sm md:text-base">Gerencie suas ideias de exercícios para os treinos.</p>
        </div>
        <a href="{{ route('professor.ideias-exercicios.create') }}" class="bg-gradient-blue text-white px-5 py-3 rounded-lg font-medium hover:opacity-95 transition w-full sm:w-auto text-center">
            + Nova Ideia
        </a>
    </div>

    <!-- Lista -->
    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        @if($ideias->isEmpty())
            <div class="text-center py-12 text-gray-300">Nenhuma ideia de exercício cadastrada ainda.</div>
        @else
            <div class="space-y-4">
                @foreach($ideias as $ideia)
                    <div class="border border-gray-600 rounded-lg p-5 bg-gray-800/40">
                        <div class="flex items-start justify-between gap-4 flex-col sm:flex-row">
                            <div class="min-w-0 w-full sm:w-auto">
                                <h3 class="text-lg font-semibold text-white">{{ $ideia->nome }}</h3>
                                <p class="text-gray-300 mt-2 whitespace-pre-line break-words">{{ $ideia->descricao }}</p>
                                @if($ideia->video_url)
                                    <a href="{{ $ideia->video_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1 mt-2 text-blue-400 hover:text-blue-300 text-sm">
                                        🎬 Ver vídeo
                                    </a>
                                @endif
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0 mt-3 sm:mt-0">
                                <a href="{{ route('professor.ideias-exercicios.edit', $ideia) }}" class="px-3 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white text-sm">Editar</a>
                                <form method="POST" action="{{ route('professor.ideias-exercicios.destroy', $ideia) }}" onsubmit="return confirm('Tem certeza que deseja excluir esta ideia?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white text-sm">Excluir</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
