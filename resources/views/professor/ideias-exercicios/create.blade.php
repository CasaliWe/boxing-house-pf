@extends('layouts.app')

@section('title', 'Nova Ideia de Exercício')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold text-blue-400">➕ Nova Ideia de Exercício</h1>
        <p class="text-gray-400">Cadastre uma nova ideia de exercício para seus treinos.</p>
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        <form method="POST" action="{{ route('professor.ideias-exercicios.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @include('professor.ideias-exercicios._form')
        </form>
    </div>
</div>
@endsection
