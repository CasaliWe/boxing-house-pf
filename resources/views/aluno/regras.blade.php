@extends('layouts.app')

@section('title', 'Regras do CT')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-semibold text-blue-400 mb-4">📜 Regras do Centro de Treinamento</h1>
    <p class="text-gray-300 mb-6">Leia atentamente as regras abaixo. O cumprimento é obrigatório para treinar na Boxing House PF.</p>

    @forelse($regras as $regra)
        <div class="bg-gray-800 border border-gray-700 rounded-lg p-4 mb-4">
            <div class="text-gray-300 whitespace-pre-line mt-2">{{ $regra->conteudo }}</div>
        </div>
    @empty
        <div class="text-gray-400">Nenhuma regra cadastrada no momento.</div>
    @endforelse
</div>
@endsection
