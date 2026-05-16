@extends('layouts.app')

@section('title', 'Ideias de Exercícios')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- Cabeçalho da página --}}
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Ideias de exercícios</h1>
            <p class="text-sm text-gray-400 mt-1">Banco de ideias para usar nos treinos</p>
        </div>
        <a href="{{ route('professor.ideias-exercicios.create') }}"
           style="background-color: #2563eb; color: #ffffff;"
           onmouseover="this.style.backgroundColor='#1d4ed8'"
           onmouseout="this.style.backgroundColor='#2563eb'"
           class="inline-flex items-center gap-2 text-sm font-medium px-4 py-2 rounded-md transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nova ideia
        </a>
    </div>

    {{-- Lista --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
            <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-white">Banco de exercícios</h3>
                <p class="text-xs text-gray-400">Ideias com descrição e vídeo de referência</p>
            </div>
        </div>

        <div class="p-6">
            @if($ideias->isEmpty())
                <div class="text-center py-12 text-sm text-gray-500">Nenhuma ideia de exercício cadastrada ainda.</div>
            @else
                <div class="space-y-3">
                    @foreach($ideias as $ideia)
                        <div class="bg-gray-800/40 border border-gray-700 hover:border-blue-500/40 rounded-lg p-4 transition-all">
                            <div class="flex items-start justify-between gap-4 flex-col sm:flex-row">
                                <div class="min-w-0 flex-1">
                                    <h3 class="text-base font-semibold text-white">{{ $ideia->nome }}</h3>
                                    <p class="text-sm text-gray-300 mt-1.5 whitespace-pre-line wrap-break-word">{{ $ideia->descricao }}</p>
                                    @if($ideia->video_path)
                                        <div class="mt-3">
                                            <video controls class="w-full max-w-sm rounded-md border border-gray-700">
                                                <source src="{{ asset($ideia->video_path) }}" type="video/mp4">
                                                Seu navegador não suporta vídeo.
                                            </video>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    <a href="{{ route('professor.ideias-exercicios.edit', $ideia) }}"
                                       style="background-color: #2563eb; color: #ffffff;"
                                       onmouseover="this.style.backgroundColor='#1d4ed8'"
                                       onmouseout="this.style.backgroundColor='#2563eb'"
                                       class="text-xs font-medium px-3 py-1.5 rounded-md transition-colors">
                                        Editar
                                    </a>
                                    <form method="POST" action="{{ route('professor.ideias-exercicios.destroy', $ideia) }}" onsubmit="return confirm('Tem certeza que deseja excluir esta ideia?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                style="background-color: #dc2626; color: #ffffff;"
                                                onmouseover="this.style.backgroundColor='#b91c1c'"
                                                onmouseout="this.style.backgroundColor='#dc2626'"
                                                class="text-xs font-medium px-3 py-1.5 rounded-md transition-colors">
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
