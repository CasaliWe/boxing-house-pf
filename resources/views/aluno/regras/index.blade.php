@extends('layouts.app')

@section('title', 'Regras do CT')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Cabeçalho da página --}}
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Regras do Centro de Treinamento</h1>
            <p class="text-sm text-gray-400 mt-1">Leitura obrigatória para treinar na Boxing House PF</p>
        </div>
    </div>

    {{-- Lista de regras --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
            <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-7 4h8M5 6h14M7 8h10M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-white">Regras vigentes</h3>
                <p class="text-xs text-gray-400">O cumprimento é obrigatório para todos os alunos</p>
            </div>
        </div>

        <div class="p-6 space-y-3">
            @forelse($regras as $index => $regra)
                <div class="bg-gray-800/40 border border-gray-700 rounded-lg p-5 flex gap-4">
                    <div class="w-8 h-8 rounded-md bg-blue-500/15 flex items-center justify-center text-blue-400 text-sm font-semibold shrink-0">
                        {{ $index + 1 }}
                    </div>
                    <div class="text-sm text-gray-200 whitespace-pre-line leading-relaxed">{{ $regra->conteudo }}</div>
                </div>
            @empty
                <div class="text-center py-12 text-sm text-gray-500">Nenhuma regra cadastrada no momento.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
