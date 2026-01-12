@extends('layouts.app')

@section('title', 'Editar Horário')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-blue-400">✏️ Editar Horário</h1>
            <p class="text-gray-400">Atualize o dia e o intervalo deste horário.</p>
        </div>
        <form method="POST" action="{{ route('professor.horarios.destroy', $horario) }}" onsubmit="return confirm('Tem certeza que deseja excluir este horário?');">
            @csrf
            @method('DELETE')
            <button class="px-4 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white">Excluir</button>
        </form>
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        <form method="POST" action="{{ route('professor.horarios.update', $horario) }}" class="space-y-6">
            @csrf
            @method('PUT')
            @include('professor.horarios._form', ['horario' => $horario])
        </form>
    </div>
</div>
@endsection
