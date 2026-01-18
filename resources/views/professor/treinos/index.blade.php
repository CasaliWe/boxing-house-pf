@extends('layouts.app')

@section('title', 'Treinos')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="w-full sm:w-auto">
            <h1 class="text-2xl md:text-3xl font-bold text-blue-400">🥊 Treinos</h1>
            <p class="text-gray-400 text-sm md:text-base">Registre a foto, a data e marque os alunos presentes.</p>
        </div>
        <a href="{{ route('professor.treinos.create') }}" class="bg-gradient-blue text-white px-5 py-3 rounded-lg font-medium w-full sm:w-auto text-center transition duration-150 hover:opacity-95 active:scale-95 focus:outline-none focus:ring-2 focus:ring-blue-500">+ Novo Treino</a>
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        @if($treinos->isEmpty())
            <div class="text-center py-12 text-gray-300">Nenhum treino cadastrado ainda.</div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($treinos as $treino)
                    <div class="border border-gray-600 rounded-lg p-5 bg-gray-800/40">
                        <div class="aspect-video mb-3 overflow-hidden rounded">
                            <img src="{{ asset('storage/'.$treino->foto_path) }}" alt="Foto do treino" class="w-full h-full object-cover">
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm text-gray-400">Data</div>
                                <div class="text-white font-semibold">{{ $treino->data->format('d/m/Y') }}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-400">Alunos presentes</div>
                                <div class="text-white font-semibold">{{ $treino->alunos_count }}</div>
                            </div>
                        </div>
                        <div class="mt-4 flex flex-col gap-2">
                            <a href="{{ route('professor.treinos.show', $treino) }}" class="block w-full h-10 px-3 py-2 rounded-md border border-gray-600 text-gray-200 hover:bg-gray-700 text-sm text-center transition duration-150 active:scale-95 focus:outline-none focus:ring-2 focus:ring-gray-500">Ver</a>
                            <a href="{{ route('professor.treinos.edit', $treino) }}" class="block w-full h-10 px-3 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white text-sm text-center transition duration-150 active:scale-95 focus:outline-none focus:ring-2 focus:ring-blue-500">Editar</a>
                            <form method="POST" action="{{ route('professor.treinos.destroy', $treino) }}" onsubmit="return confirm('Excluir este treino?')" class="flex">
                                @csrf
                                @method('DELETE')
                                <button class="block w-full h-10 px-3 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white text-sm text-center transition duration-150 active:scale-95 focus:outline-none focus:ring-2 focus:ring-red-500">Excluir</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div>{{ $treinos->links() }}</div>
</div>
@endsection
