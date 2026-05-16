@extends('layouts.app')

@section('title', 'Nova Ideia de Exercício')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Nova ideia de exercício</h1>
            <p class="text-sm text-gray-400 mt-1">Cadastre uma nova ideia para seus treinos</p>
        </div>
        <a href="{{ route('professor.ideias-exercicios.index') }}" class="text-sm text-gray-400 hover:text-blue-400">← Voltar</a>
    </div>

    <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
        <form method="POST" action="{{ route('professor.ideias-exercicios.store') }}" enctype="multipart/form-data">
            @csrf
            @include('professor.ideias-exercicios._form')
        </form>
    </div>
</div>
@endsection
