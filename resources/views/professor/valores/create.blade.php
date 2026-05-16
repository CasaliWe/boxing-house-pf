@extends('layouts.app')

@section('title', 'Novo Valor')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Novo valor</h1>
            <p class="text-sm text-gray-400 mt-1">Cadastre o preço por aula conforme a quantidade mensal</p>
        </div>
        <a href="{{ route('professor.valores.index') }}" class="text-sm text-gray-400 hover:text-blue-400">← Voltar</a>
    </div>

    <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
        <form method="POST" action="{{ route('professor.valores.store') }}">
            @csrf
            @include('professor.valores._form')
        </form>
    </div>
</div>
@endsection
