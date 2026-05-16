@extends('layouts.app')

@section('title', 'Dashboard Aluno')

@section('content')
<style>
    /* Esconde a scrollbar mantendo a rolagem funcional */
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    .scrollbar-hide::-webkit-scrollbar { display: none; }
</style>

<div class="max-w-7xl mx-auto space-y-6">

    {{-- Cabeçalho da página --}}
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Olá, {{ auth()->user()->name }}</h1>
            <p class="text-sm text-gray-400 mt-1">Bem-vindo de volta ao seu portal de treinamento</p>
        </div>
        <div class="text-right">
            <div class="text-xs text-gray-500 uppercase tracking-wider">Hoje</div>
            <div class="text-sm text-gray-300 font-medium">{{ \Carbon\Carbon::now()->translatedFormat('l, d \d\e F') }}</div>
        </div>
    </div>

    {{-- Aviso quando o pacote acabou --}}
    @if($aulasRestantes <= 0)
        <div class="bg-red-950/40 border border-red-800/60 rounded-lg p-5 flex items-start gap-4">
            <div class="w-10 h-10 rounded-md bg-red-500/20 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div class="flex-1">
                <div class="text-base font-semibold text-red-100">Seu pacote de aulas acabou</div>
                <p class="text-sm text-red-200/80 mt-1">Você continua com acesso ao sistema, mas precisa comprar mais aulas para seguir treinando.</p>
                @if($config && $config->whatsapp)
                    <a href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}?text=Olá! Quero comprar mais aulas. Meu nome é {{ auth()->user()->name }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 mt-3 px-4 py-2 rounded-md bg-green-600 hover:bg-green-700 text-white text-sm font-medium transition-colors">
                        Comprar mais aulas
                    </a>
                @endif
            </div>
        </div>
    @endif

    {{-- Cards de estatísticas principais --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        {{-- Card: Próximo treino --}}
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg p-5 hover:border-gray-700 transition-colors">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs text-gray-400 uppercase tracking-wider">Próximo treino</span>
                <div class="w-8 h-8 rounded-md bg-blue-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            @if($proximoTreino)
                <div class="text-xl font-bold text-white">{{ $proximoTreino['dia_label'] }}</div>
                <div class="text-2xl font-bold text-blue-400 mt-0.5">{{ $proximoTreino['hora'] }}</div>
                <div class="text-xs text-gray-500 mt-1">{{ $proximoTreino['date']->format('d/m/Y') }}</div>
            @else
                <div class="text-base text-gray-400 py-2">Sem horários definidos</div>
            @endif
        </div>

        {{-- Card: Aulas restantes --}}
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg p-5 hover:border-gray-700 transition-colors">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs text-gray-400 uppercase tracking-wider">Aulas restantes</span>
                <div class="w-8 h-8 rounded-md {{ $aulasRestantes > 0 ? 'bg-green-500/10' : 'bg-red-500/10' }} flex items-center justify-center">
                    <svg class="w-4 h-4 {{ $aulasRestantes > 0 ? 'text-green-400' : 'text-red-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold {{ $aulasRestantes > 0 ? 'text-green-400' : 'text-red-400' }}">{{ $aulasRestantes }}</div>
            <div class="text-xs text-gray-500 mt-1">de {{ $aulasContratadas }} contratada(s)</div>
        </div>

        {{-- Card: Total de aulas feitas --}}
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg p-5 hover:border-gray-700 transition-colors">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs text-gray-400 uppercase tracking-wider">Aulas feitas</span>
                <div class="w-8 h-8 rounded-md bg-green-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.6.9-1 1.651-1.155.751-.154 1.532.055 2.152.625L19.64 6.55a2 2 0 01.25 2.83l-7.18 8.61c-.34.407-.808.695-1.335.82L9 19.5l.694-2.375c.125-.527.413-.995.82-1.335l8.61-7.18a2 2 0 002.83.25z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-green-400">{{ $totalAulas }}</div>
            <div class="text-xs text-gray-500 mt-1">Total acumulado</div>
        </div>
    </div>

    {{-- Bloco: o que já aprendi --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-white">O que já aprendi</h3>
                    <p class="text-xs text-gray-400">Suas aulas registradas</p>
                </div>
            </div>
            <a href="{{ route('aluno.treinos') }}" class="text-xs text-blue-400 hover:text-blue-300 hover:underline">ver todos →</a>
        </div>

        <div class="p-6">
            @if(empty($aprendizados))
                <div class="text-center py-10 text-sm text-gray-500">Sem registros ainda</div>
            @else
                <div class="max-h-56 overflow-y-scroll divide-y divide-gray-800 scrollbar-hide">
                    @foreach($aprendizados as $item)
                        <div class="flex items-center justify-between gap-3 py-3 first:pt-0 last:pb-0">
                            <div class="flex items-center gap-3 min-w-0">
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-green-500/20 text-green-300 shrink-0">
                                    Aula {{ $item['numero'] }}
                                </span>
                                <span class="text-sm text-gray-200 truncate">{{ $item['descricao'] }}</span>
                            </div>
                            @if($item['video_path'])
                                <img src="{{ asset($item['video_path']) }}" alt="Imagem da sequência" class="h-9 w-9 rounded object-cover border border-gray-700 shrink-0">
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Atalhos rápidos --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-white">Atalhos</h3>
                <p class="text-xs text-gray-400">Acesse rapidamente o que você usa mais</p>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
            <a href="{{ route('aluno.treinos') }}"
               class="flex items-center gap-2 px-3 py-2.5 rounded-md bg-gray-800/50 hover:bg-gray-700/60 border border-gray-700 hover:border-blue-500/50 text-sm text-gray-200 transition-all">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                Meus Treinos
            </a>
            <a href="{{ route('aluno.horarios') }}"
               class="flex items-center gap-2 px-3 py-2.5 rounded-md bg-gray-800/50 hover:bg-gray-700/60 border border-gray-700 hover:border-blue-500/50 text-sm text-gray-200 transition-all">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z" /></svg>
                Meus Horários
            </a>
            <a href="{{ route('aluno.perfil') }}"
               class="flex items-center gap-2 px-3 py-2.5 rounded-md bg-gray-800/50 hover:bg-gray-700/60 border border-gray-700 hover:border-blue-500/50 text-sm text-gray-200 transition-all">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                Meu Perfil
            </a>
            <a href="{{ route('aluno.regras') }}"
               class="flex items-center gap-2 px-3 py-2.5 rounded-md bg-gray-800/50 hover:bg-gray-700/60 border border-gray-700 hover:border-blue-500/50 text-sm text-gray-200 transition-all">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 6h14M7 8h10M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                Regras do CT
            </a>
        </div>
    </div>
</div>

@include('components.pwa-install-prompt')
@endsection
