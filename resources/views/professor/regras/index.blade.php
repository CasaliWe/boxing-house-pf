@extends('layouts.app')

@section('title', 'Regras e Aceites')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- Cabeçalho da página --}}
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Regras e aceites</h1>
            <p class="text-sm text-gray-400 mt-1">Regras da academia e termos apresentados aos alunos</p>
        </div>
        <a href="{{ route('professor.regras.create') }}"
           style="background-color: #2563eb; color: #ffffff;"
           onmouseover="this.style.backgroundColor='#1d4ed8'"
           onmouseout="this.style.backgroundColor='#2563eb'"
           class="inline-flex items-center gap-2 text-sm font-medium px-4 py-2 rounded-md transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nova regra
        </a>
    </div>

    {{-- Lista --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
            <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-7 4h8M5 6h14M7 8h10M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-white">Regras cadastradas</h3>
                <p class="text-xs text-gray-400">O aluno aceita estas regras no cadastro</p>
            </div>
        </div>

        <div class="p-6">
            @if($regras->isEmpty())
                <div class="text-center py-12 text-sm text-gray-500">Nenhuma regra cadastrada ainda.</div>
            @else
                <div class="space-y-3">
                    @foreach($regras as $regra)
                        <div class="bg-gray-800/40 border border-gray-700 rounded-lg p-4">
                            <div class="flex items-start justify-between gap-4 flex-col sm:flex-row">
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2 flex-wrap mb-1.5">
                                        <h3 class="text-base font-semibold text-white">{{ $regra->titulo }}</h3>
                                        <span class="text-xs font-semibold px-2 py-0.5 rounded {{ $regra->ativo ? 'bg-green-500/20 text-green-300' : 'bg-gray-700 text-gray-300' }}">
                                            {{ $regra->ativo ? 'Ativo' : 'Inativo' }}
                                        </span>
                                        @if(!is_null($regra->ordem))
                                            <span class="text-xs text-gray-500">ordem: {{ $regra->ordem }}</span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-300 whitespace-pre-line wrap-break-word">{{ $regra->conteudo }}</p>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    <a href="{{ route('professor.regras.edit', $regra) }}"
                                       style="background-color: #2563eb; color: #ffffff;"
                                       onmouseover="this.style.backgroundColor='#1d4ed8'"
                                       onmouseout="this.style.backgroundColor='#2563eb'"
                                       class="text-xs font-medium px-3 py-1.5 rounded-md transition-colors">
                                        Editar
                                    </a>
                                    <form method="POST" action="{{ route('professor.regras.destroy', $regra) }}" onsubmit="return confirm('Tem certeza que deseja excluir este item?');">
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
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
