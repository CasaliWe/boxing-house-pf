@extends('layouts.app')

@section('title', 'Editar Ideia de Exercício')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-blue-400">✏️ Editar Ideia de Exercício</h1>
            <p class="text-gray-400">Atualize os dados desta ideia de exercício.</p>
        </div>
        <form method="POST" action="{{ route('professor.ideias-exercicios.destroy', $ideia) }}" onsubmit="return confirm('Tem certeza que deseja excluir esta ideia?');">
            @csrf
            @method('DELETE')
            <button class="px-4 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white">Excluir</button>
        </form>
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        <form method="POST" action="{{ route('professor.ideias-exercicios.update', $ideia) }}" class="space-y-6">
            @csrf
            @method('PUT')
            @include('professor.ideias-exercicios._form', ['ideia' => $ideia])
        </form>
    </div>
</div>
@endsection
