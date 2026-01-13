@extends('layouts.app')

@section('title', 'Regras e Aceites')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between flex-col gap-4 sm:flex-row">
        <div>
            <h1 class="text-3xl font-bold text-blue-400">📜 Regras e Aceites</h1>
            <p class="text-gray-400">Gerencie as regras da academia e os termos de aceite apresentados aos alunos.</p>
        </div>
        <a href="{{ route('professor.regras.create') }}" class="bg-gradient-blue text-white px-5 py-3 rounded-lg font-medium hover:opacity-95 transition">+ Nova Regra/Aceite</a>
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        @if($regras->isEmpty())
            <div class="text-center py-12 text-gray-300">Nenhuma regra/aceite cadastrado ainda.</div>
        @else
            <div class="space-y-4">
                @foreach($regras as $regra)
                    <div class="border border-gray-600 rounded-lg p-5 bg-gray-800/40">
                        <div class="flex items-start justify-between gap-4 flex-col sm:flex-row">
                            <div class="min-w-0 w-full sm:w-auto">
                                <div class="flex items-center gap-3">
                                    <h3 class="text-lg font-semibold text-white truncate">{{ $regra->titulo }}</h3>
                                    <span class="px-2 py-1 text-xs rounded {{ $regra->ativo ? 'bg-green-700 text-green-100' : 'bg-gray-600 text-gray-100' }}">{{ $regra->ativo ? 'Ativo' : 'Inativo' }}</span>
                                    @if(!is_null($regra->ordem))
                                        <span class="text-xs text-gray-400">ordem: {{ $regra->ordem }}</span>
                                    @endif
                                </div>
                                <p class="text-gray-300 mt-2 whitespace-pre-line break-words">{{ $regra->conteudo }}</p>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0 mt-3 sm:mt-0">
                                <a href="{{ route('professor.regras.edit', $regra) }}" class="px-3 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white text-sm">Editar</a>
                                <form method="POST" action="{{ route('professor.regras.destroy', $regra) }}" onsubmit="return confirm('Tem certeza que deseja excluir este item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white text-sm">Excluir</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
