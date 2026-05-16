@extends('layouts.app')

@section('title', 'Editar Treino')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Editar treino</h1>
            <p class="text-sm text-gray-400 mt-1">Atualize os dados e presenças deste treino</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('professor.treinos.index') }}" class="text-sm text-gray-400 hover:text-blue-400">← Voltar</a>
            <form method="POST" action="{{ route('professor.treinos.destroy', $treino) }}" onsubmit="return confirm('Excluir este treino?')">
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

    <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
        <form method="POST" action="{{ route('professor.treinos.update', $treino) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('professor.treinos._form')
        </form>
    </div>
</div>
@endsection
