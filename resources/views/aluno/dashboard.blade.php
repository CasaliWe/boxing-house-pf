@extends('layouts.app')

@section('title', 'Dashboard Aluno')

@section('content')
<style>
.scrollbar-hide {
    -ms-overflow-style: none;  /* Internet Explorer 10+ */
    scrollbar-width: none;  /* Firefox */
}
.scrollbar-hide::-webkit-scrollbar { 
    display: none;  /* Safari and Chrome */
}
</style>

<div class="space-y-8">
    <!-- Header -->
    <div class="text-center">
        <h1 class="text-3xl font-bold text-blue-400 mb-2">🥊 Bem-vindo, {{ auth()->user()->name }}!</h1>
        <p class="text-gray-400">Seu portal de treinamento na Boxing House PF</p>
    </div>

    <!-- Cards principais -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Próximo Treino -->
        <div class="bg-gradient-card border border-gray-600 rounded-xl p-8 text-center">
            <div class="text-gray-300 text-base mb-4">Próximo treino</div>
            @if($proximoTreino)
                <div class="text-blue-400 text-3xl font-bold">{{ $proximoTreino['dia_label'] }}</div>
                <div class="text-white text-4xl font-semibold mt-2">{{ $proximoTreino['hora'] }}</div>
                <div class="text-gray-400 text-sm mt-2">{{ $proximoTreino['date']->format('d/m/Y') }}</div>
            @else
                <div class="text-gray-300 text-lg">Sem horários definidos</div>
            @endif
        </div>

        <!-- Total de Aulas -->
        <div class="bg-gradient-card border border-gray-600 rounded-xl p-8 text-center">
            <div class="text-gray-300 text-base mb-4">Total de aulas</div>
            <div class="text-green-400 text-5xl font-bold">{{ $totalAulas }}</div>
            <div class="text-gray-400 text-sm mt-2">Sequenciais e especiais somadas</div>
        </div>

        <!-- Vencimento Mensalidade -->
        <div class="bg-gradient-card border border-gray-600 rounded-xl p-8 text-center">
            <div class="text-gray-300 text-base mb-4">Vencimento</div>
            @if($vencimentoMensalidade)
                @php
                    $vencimento = \Illuminate\Support\Carbon::parse($vencimentoMensalidade);
                    $hoje = \Illuminate\Support\Carbon::today();
                    $diasRestantes = $hoje->diffInDays($vencimento, false);
                    
                    if ($hoje->gt($vencimento)) {
                        $corTexto = 'text-red-400';
                        $status = 'VENCIDA';
                    } elseif ($diasRestantes <= 2) {
                        $corTexto = 'text-yellow-400';
                        $status = 'VENCE HOJE';
                        if ($diasRestantes == 1) $status = 'VENCE AMANHÃ';
                        if ($diasRestantes == 2) $status = 'VENCE EM 2 DIAS';
                    } else {
                        $corTexto = 'text-green-400';
                        $status = 'OK';
                    }
                @endphp
                <div class="{{ $corTexto }} text-3xl font-bold">{{ $vencimento->format('d/m/Y') }}</div>
                <div class="{{ $corTexto }} text-lg font-semibold mt-2">{{ $status }}</div>
            @else
                <div class="text-gray-300 text-lg">Não definido</div>
            @endif
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
                <div class="max-h-40 overflow-y-scroll divide-y divide-gray-700 rounded border border-gray-700 scrollbar-hide">
                    @foreach($aprendizados as $item)
                        <div class="flex items-center justify-between gap-3 p-3">
                            <div class="flex items-center gap-3">
                                <span class="px-2 py-1 text-xs rounded bg-green-700 text-green-100">Aula {{ $item['numero'] }}</span>
                                <span class="text-gray-200 text-sm">{{ $item['descricao'] }}</span>
                            </div>
                            @if($item['video_path'])
                                <img src="{{ asset($item['video_path']) }}" alt="Imagem da sequência" class="h-8 w-8 rounded object-cover border border-gray-600">
                            @endif
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

<!-- Modal de vídeo das sequências -->
<div id="modalVideoSequencia" class="fixed inset-0 z-50 hidden bg-black/70">
    <div class="absolute inset-0 flex items-center justify-center" onclick="closeVideoModal()">
        <video id="videoSequencia" controls class="block max-h-[90vh] max-w-[90vw] bg-black rounded" onclick="event.stopPropagation();"></video>
    </div>
</div>

<!-- PWA Install Prompt -->
@include('components.pwa-install-prompt')

<script>
function abrirModalVideo(src){
    const modal = document.getElementById('modalVideoSequencia');
    const v = document.getElementById('videoSequencia');
    v.src = src;
    modal.classList.remove('hidden');
}
function closeVideoModal() {
    const modal = document.getElementById('modalVideoSequencia');
    const v = document.getElementById('videoSequencia');
    v.pause();
    modal.classList.add('hidden');
}
</script>
@endsection