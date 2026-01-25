@extends('layouts.app')

@section('title', 'Detalhes do Treino')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="w-full sm:w-auto">
            <h1 class="text-2xl md:text-3xl font-bold text-blue-400">🥊 Detalhes do Treino</h1>
            <p class="text-gray-400 text-sm md:text-base">Informações completas e lista de presentes.</p>
        </div>
        <a href="{{ route('professor.treinos.index') }}" class="px-4 py-2 rounded-md border border-gray-600 text-gray-200 hover:bg-gray-700 w-full sm:w-auto text-center">Voltar</a>
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        <div class="aspect-video mb-4 overflow-hidden rounded">
            <img src="{{ asset($treino->foto_path) }}" alt="Foto do treino" class="w-full h-full object-cover">
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <div class="text-sm text-gray-400">Data</div>
                <div class="text-white font-semibold">{{ $treino->data->format('d/m/Y') }}</div>
            </div>
            <div>
                <div class="text-sm text-gray-400">Tipo</div>
                <div class="text-white font-semibold">{{ $treino->especial ? 'Aula especial' : 'Aula padrão' }}</div>
            </div>
            <div>
                <div class="text-sm text-gray-400">Alunos presentes</div>
                <div class="text-white font-semibold">{{ $treino->alunos->count() }}</div>
            </div>
        </div>

        <div class="mt-6">
            <h2 class="text-lg font-semibold text-white mb-2">Lista de alunos presentes</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-2">
                @forelse($treino->alunos as $aluno)
                    <div class="border border-gray-600 rounded p-3 bg-gray-800/40 text-gray-200">{{ $aluno->name }}<span class="text-gray-500"> — {{ $aluno->email }}</span></div>
                @empty
                    <p class="text-gray-300">Nenhum aluno marcado neste treino.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
