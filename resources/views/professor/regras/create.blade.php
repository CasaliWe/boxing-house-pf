@extends('layouts.app')

@section('title', 'Nova Regra/Aceite')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold text-blue-400">➕ Nova Regra/Aceite</h1>
        <p class="text-gray-400">Cadastre regras e termos de aceite que serão apresentados aos alunos.</p>
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        <form method="POST" action="{{ route('professor.regras.store') }}" class="space-y-6">
            @csrf
            @include('professor.regras._form')
        </form>
    </div>
</div>
@endsection
