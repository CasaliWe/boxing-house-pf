@extends('layouts.app')

@section('title', 'Editar Valor')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-blue-400">✏️ Editar Valor</h1>
            <p class="text-gray-400">Atualize o preço conforme a quantidade de treinos semanais.</p>
        </div>
        <form method="POST" action="{{ route('professor.valores.destroy', $valor) }}" onsubmit="return confirm('Tem certeza que deseja excluir este valor?');">
            @csrf
            @method('DELETE')
            <button class="px-4 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white">Excluir</button>
        </form>
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        <form method="POST" action="{{ route('professor.valores.update', $valor) }}" class="space-y-6">
            @csrf
            @method('PUT')
            @include('professor.valores._form', ['valor' => $valor])
        </form>
    </div>
</div>
@endsection
