@extends('layouts.app')

@section('title', 'Novo Acesso')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Novo acesso</h1>
            <p class="text-sm text-gray-400 mt-1">Cadastre login e senha de uma plataforma</p>
        </div>
    </div>

    <form method="POST" action="{{ route('professor.acessos.store') }}">
        @csrf
        @include('professor.acessos._form')
    </form>
</div>
@endsection
