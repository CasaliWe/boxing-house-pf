@extends('layouts.app')

@section('title', 'Novo Treino')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-blue-400">🥊 Novo Treino</h1>
            <p class="text-gray-400">Preencha os dados e marque os alunos presentes.</p>
        </div>
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        <form method="POST" action="{{ route('professor.treinos.store') }}" enctype="multipart/form-data">
            @csrf
            @include('professor.treinos._form')
        </form>
    </div>
</div>
@endsection
