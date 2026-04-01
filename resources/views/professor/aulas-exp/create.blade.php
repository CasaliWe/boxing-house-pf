@extends('layouts.app')

@section('title', 'Nova Aula EXP')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold text-blue-400">➕ Nova Aula EXP</h1>
        <p class="text-gray-400">Cadastre uma nova aula experimental marcada.</p>
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        <form method="POST" action="{{ route('professor.aulas-exp.store') }}" class="space-y-6">
            @csrf
            @include('professor.aulas-exp._form')
        </form>
    </div>
</div>
@endsection
