@extends('layouts.app')

@section('title', 'Dashboard Aluno')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="text-center">
        <h1 class="text-3xl font-bold text-blue-400 mb-2">🥊 Bem-vindo, {{ auth()->user()->name }}!</h1>
        <p class="text-gray-400">Seu portal de treinamento na Boxing House PF</p>
    </div>

    <!-- Cards principais -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Próximo Treino -->
        <div class="bg-gradient-card border border-gray-600 rounded-xl p-6 text-center">
            <div class="text-gray-300 text-sm mb-2">Próximo treino</div>
            @if($proximoTreino)
                <div class="text-blue-400 text-xl font-bold">{{ $proximoTreino['dia_label'] }}</div>
                <div class="text-white text-2xl font-semibold mt-1">{{ $proximoTreino['hora'] }}</div>
                <div class="text-gray-400 text-xs mt-1">{{ $proximoTreino['date']->format('d/m/Y') }}</div>
            @else
                <div class="text-gray-300">Sem horários definidos</div>
            @endif
        </div>

        <!-- Total de Aulas -->
        <div class="bg-gradient-card border border-gray-600 rounded-xl p-6 text-center">
            <div class="text-gray-300 text-sm mb-2">Total de aulas</div>
            <div class="text-green-400 text-4xl font-bold">{{ $totalAulas }}</div>
            <div class="text-gray-400 text-xs mt-1">Sequenciais e especiais somadas</div>
        </div>

        <!-- O que já aprendi -->
        <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="text-gray-300 text-sm">O que já aprendi</div>
                <a href="{{ route('aluno.treinos') }}" class="text-xs text-blue-400 hover:underline">ver todos</a>
            </div>
            @if(empty($aprendizados))
                <div class="text-center text-gray-300">Sem registros ainda</div>
            @else
                <div class="max-h-40 overflow-auto divide-y divide-gray-700 rounded border border-gray-700">
                    @foreach($aprendizados as $item)
                        <div class="flex items-center gap-3 p-3">
                            <span class="px-2 py-1 text-xs rounded bg-green-700 text-green-100">Aula {{ $item['numero'] }}</span>
                            <span class="text-gray-200 text-sm">{{ $item['descricao'] }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Ações rápidas -->
    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h3 class="text-xl font-bold text-blue-400">Ações rápidas</h3>
                <p class="text-gray-400 text-sm">Acesse suas principais páginas com um clique</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('aluno.treinos') }}" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white">Ver Meus Treinos</a>
                <a href="{{ route('aluno.perfil') }}" class="px-4 py-2 rounded-lg border border-gray-600 text-gray-200 hover:bg-gray-700">Meu Perfil</a>
                <a href="{{ route('aluno.horarios') }}" class="px-4 py-2 rounded-lg border border-gray-600 text-gray-200 hover:bg-gray-700">Meus Horários</a>
                <a href="{{ route('aluno.regras') }}" class="px-4 py-2 rounded-lg border border-gray-600 text-gray-200 hover:bg-gray-700">Regras do CT</a>
            </div>
        </div>
    </div>
</div>
@endsection