@extends('layouts.app')

@section('title', 'Novo Horário')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold text-blue-400">➕ Novo Horário</h1>
        <p class="text-gray-400">Cadastre um novo dia e intervalo de horário disponível.</p>
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        <form method="POST" action="{{ route('professor.horarios.store') }}" class="space-y-6">
            @csrf
            @include('professor.horarios._form')
        </form>
    </div>
</div>
@endsection
