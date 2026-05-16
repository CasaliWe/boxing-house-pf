@extends('layouts.app')

@section('title', 'Editar Aula EXP')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Cabeçalho com botão de excluir --}}
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Editar aula experimental</h1>
            <p class="text-sm text-gray-400 mt-1">Atualize os dados desta aula</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('professor.aulas-exp.index') }}" class="text-sm text-gray-400 hover:text-blue-400">← Voltar</a>
            <form method="POST" action="{{ route('professor.aulas-exp.destroy', $aula) }}" onsubmit="return confirm('Tem certeza que deseja excluir esta aula EXP?');">
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

    {{-- Form --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
        <form method="POST" action="{{ route('professor.aulas-exp.update', $aula) }}">
            @csrf
            @method('PUT')
            @include('professor.aulas-exp._form', ['aula' => $aula])
        </form>
    </div>
</div>
@endsection
