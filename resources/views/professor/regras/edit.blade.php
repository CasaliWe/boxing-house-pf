@extends('layouts.app')

@section('title', 'Editar Regra/Aceite')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-blue-400">✏️ Editar Regra/Aceite</h1>
            <p class="text-gray-400">Atualize os detalhes desta regra/termo.</p>
        </div>
        <form method="POST" action="{{ route('professor.regras.destroy', $regra) }}" onsubmit="return confirm('Tem certeza que deseja excluir este item?');">
            @csrf
            @method('DELETE')
            <button class="px-4 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white">Excluir</button>
        </form>
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        <form method="POST" action="{{ route('professor.regras.update', $regra) }}" class="space-y-6">
            @csrf
            @method('PUT')
            @include('professor.regras._form', ['regra' => $regra])
        </form>
    </div>
</div>
@endsection
