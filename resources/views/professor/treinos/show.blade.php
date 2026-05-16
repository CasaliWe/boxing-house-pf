@extends('layouts.app')

@section('title', 'Detalhes do Treino')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    {{-- Cabeçalho --}}
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Detalhes do treino</h1>
            <p class="text-sm text-gray-400 mt-1">Informações completas e lista de presentes</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('professor.treinos.index') }}" class="text-sm text-gray-400 hover:text-blue-400">← Voltar</a>
            <a href="{{ route('professor.treinos.edit', $treino) }}"
               style="background-color: #2563eb; color: #ffffff;"
               onmouseover="this.style.backgroundColor='#1d4ed8'"
               onmouseout="this.style.backgroundColor='#2563eb'"
               class="text-xs font-medium px-3 py-1.5 rounded-md transition-colors">
                Editar
            </a>
        </div>
    </div>

    {{-- Foto e dados --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
        <div class="aspect-video bg-gray-900 relative">
            <img src="{{ asset($treino->foto_path) }}" alt="Foto do treino" class="w-full h-full object-cover">
            @if($treino->especial)
                <span class="absolute top-3 left-3 text-xs font-semibold px-2.5 py-1 rounded bg-purple-500/30 text-purple-200 backdrop-blur-sm border border-purple-400/30">Especial</span>
            @else
                <span class="absolute top-3 left-3 text-xs font-semibold px-2.5 py-1 rounded bg-green-500/30 text-green-200 backdrop-blur-sm border border-green-400/30">Sequencial</span>
            @endif
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gray-800/40 border border-gray-700 rounded-md p-4">
                <div class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Data</div>
                <div class="text-base font-semibold text-white mt-1">{{ $treino->data->format('d/m/Y') }}</div>
            </div>
            <div class="bg-gray-800/40 border border-gray-700 rounded-md p-4">
                <div class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Tipo</div>
                <div class="text-base font-semibold text-white mt-1">{{ $treino->especial ? 'Aula especial' : 'Aula padrão' }}</div>
            </div>
            <div class="bg-gray-800/40 border border-gray-700 rounded-md p-4">
                <div class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Presentes</div>
                <div class="text-base font-semibold text-white mt-1">{{ $treino->alunos->count() }} {{ $treino->alunos->count() === 1 ? 'aluno' : 'alunos' }}</div>
            </div>
        </div>
    </div>

    {{-- Lista de presentes --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
            <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-white">Alunos presentes</h3>
                <p class="text-xs text-gray-400">Quem treinou neste dia</p>
            </div>
        </div>
        <div class="p-6">
            @if($treino->alunos->isEmpty())
                <div class="text-center py-8 text-sm text-gray-500">Nenhum aluno marcado neste treino.</div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-2">
                    @foreach($treino->alunos as $aluno)
                        <div class="bg-gray-800/40 border border-gray-700 rounded-md p-3 flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-linear-to-br from-blue-600 to-blue-800 flex items-center justify-center text-white text-xs font-semibold shrink-0">
                                {{ mb_strtoupper(mb_substr($aluno->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <div class="text-sm font-medium text-white truncate">{{ $aluno->name }}</div>
                                <div class="text-xs text-gray-500 truncate">{{ $aluno->email }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
