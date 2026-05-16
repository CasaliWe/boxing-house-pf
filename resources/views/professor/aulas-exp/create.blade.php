@extends('layouts.app')

@section('title', 'Nova Aula EXP')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Cabeçalho --}}
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Nova aula experimental</h1>
            <p class="text-sm text-gray-400 mt-1">Cadastre uma aula experimental marcada</p>
        </div>
        <a href="{{ route('professor.aulas-exp.index') }}" class="text-sm text-gray-400 hover:text-blue-400">← Voltar</a>
    </div>

    {{-- Form --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
        <form method="POST" action="{{ route('professor.aulas-exp.store') }}">
            @csrf
            @include('professor.aulas-exp._form')
        </form>
    </div>
</div>
@endsection
