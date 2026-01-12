@extends('layouts.app')

@section('title', 'Novo Valor')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold text-blue-400">➕ Novo Valor</h1>
        <p class="text-gray-400">Cadastre o preço conforme a quantidade de treinos semanais.</p>
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        <form method="POST" action="{{ route('professor.valores.store') }}" class="space-y-6">
            @csrf
            @include('professor.valores._form')
        </form>
    </div>
</div>
@endsection
