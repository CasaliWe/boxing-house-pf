@extends('layouts.app')

@section('title', 'Dashboard Professor')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="text-center">
        <h1 class="text-3xl font-bold text-blue-400 mb-2">🥊 Dashboard Professor</h1>
        <p class="text-gray-400">Painel administrativo da Boxing House PF</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-card border border-gray-600 rounded-xl p-6 text-center">
            <div class="text-green-400 text-2xl font-bold">Em breve</div>
            <div class="text-gray-300 text-sm mt-2">Alunos Ativos</div>
        </div>
        
        <div class="bg-gradient-card border border-gray-600 rounded-xl p-6 text-center">
            <div class="text-yellow-400 text-2xl font-bold">Em breve</div>
            <div class="text-gray-300 text-sm mt-2">Treinos Esta Semana</div>
        </div>
        
        <div class="bg-gradient-card border border-gray-600 rounded-xl p-6 text-center">
            <div class="text-purple-400 text-2xl font-bold">Em breve</div>
            <div class="text-gray-300 text-sm mt-2">Faturamento Mensal</div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-gradient-card border border-gray-600 rounded-xl p-8">
        <div class="text-center">
            <div class="text-6xl mb-4">🚧</div>
            <h3 class="text-2xl font-bold text-blue-400 mb-4">Sistema em Desenvolvimento</h3>
            <p class="text-gray-300 mb-8">Novas funcionalidades serão adicionadas em breve!</p>
            
            <!-- Future Features -->
            <div class="bg-gray-800 bg-opacity-50 rounded-lg p-6 max-w-md mx-auto">
                <h4 class="text-lg font-semibold text-blue-400 mb-4">Próximas Funcionalidades:</h4>
                <ul class="space-y-2 text-left text-gray-300">
                    <li class="flex items-center">
                        <span class="text-blue-400 mr-2">•</span>
                        📊 Gerenciamento de alunos
                    </li>
                    <li class="flex items-center">
                        <span class="text-blue-400 mr-2">•</span>
                        🥊 Cadastro e controle de treinos
                    </li>
                    <li class="flex items-center">
                        <span class="text-blue-400 mr-2">•</span>
                        📈 Relatórios de performance
                    </li>
                    <li class="flex items-center">
                        <span class="text-blue-400 mr-2">•</span>
                        📅 Agendamento de aulas
                    </li>
                    <li class="flex items-center">
                        <span class="text-blue-400 mr-2">•</span>
                        💰 Controle financeiro
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection