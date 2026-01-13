@extends('layouts.app')

@section('title', 'Editar Treino')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-blue-400">🥊 Editar Treino</h1>
            <p class="text-gray-400">Atualize os dados e presenças deste treino.</p>
        </div>
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        <form method="POST" action="{{ route('professor.treinos.update', $treino) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('professor.treinos._form')
        </form>
    </div>
</div>
@endsection
