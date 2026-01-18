@extends('layouts.app')

@section('title', 'Editar Sequência de Aula')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="w-full sm:w-auto">
            <h1 class="text-2xl md:text-3xl font-bold text-blue-400">📚 Editar Sequência de Aula</h1>
            <p class="text-gray-400 text-sm md:text-base">Atualize número e conteúdo desta sequência.</p>
        </div>
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        <form method="POST" action="{{ route('professor.aulas-sequencia.update', $sequencia) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('professor.aulas._form')
        </form>
    </div>
</div>
@endsection
