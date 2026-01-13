@extends('layouts.app')

@section('title', 'Nova Sequência de Aula')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-blue-400">📚 Nova Sequência de Aula</h1>
            <p class="text-gray-400">Defina o número da aula e sua sequência.</p>
        </div>
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        <form method="POST" action="{{ route('professor.aulas-sequencia.store') }}">
            @csrf
            @include('professor.aulas._form')
        </form>
    </div>
</div>
@endsection
