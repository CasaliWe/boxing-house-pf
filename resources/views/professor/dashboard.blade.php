@extends('layouts.app')

@section('title', 'Dashboard Professor')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- Cabeçalho da página --}}
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Dashboard</h1>
            <p class="text-sm text-gray-400 mt-1">Visão geral da Boxing House PF</p>
        </div>
        <div class="text-right">
            <div class="text-xs text-gray-500 uppercase tracking-wider">Hoje</div>
            <div class="text-sm text-gray-300 font-medium">{{ \Carbon\Carbon::now()->translatedFormat('l, d \d\e F') }}</div>
        </div>
    </div>

    {{-- Cards de estatísticas dos alunos --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        {{-- Card: Total --}}
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg p-5 hover:border-gray-700 transition-colors">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs text-gray-400 uppercase tracking-wider">Total</span>
                <div class="w-8 h-8 rounded-md bg-blue-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-white">{{ $totalAlunos }}</div>
            <div class="text-xs text-gray-500 mt-1">Alunos cadastrados</div>
        </div>

        {{-- Card: Ativos --}}
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg p-5 hover:border-gray-700 transition-colors">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs text-gray-400 uppercase tracking-wider">Ativos</span>
                <div class="w-8 h-8 rounded-md bg-green-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-green-400">{{ $alunosAtivos }}</div>
            <div class="text-xs text-gray-500 mt-1">Treinando atualmente</div>
        </div>

        {{-- Card: Inativos --}}
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg p-5 hover:border-gray-700 transition-colors">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs text-gray-400 uppercase tracking-wider">Inativos</span>
                <div class="w-8 h-8 rounded-md bg-yellow-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-yellow-400">{{ $alunosInativos }}</div>
            <div class="text-xs text-gray-500 mt-1">Pausados ou parados</div>
        </div>

        {{-- Card: Pendentes --}}
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg p-5 hover:border-gray-700 transition-colors">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs text-gray-400 uppercase tracking-wider">Pendentes</span>
                <div class="w-8 h-8 rounded-md bg-purple-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-purple-400">{{ $alunosPendentes }}</div>
            <div class="text-xs text-gray-500 mt-1">Aguardando aprovação</div>
        </div>
    </div>

    {{-- Bloco principal: próxima aula --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800 flex items-center justify-between flex-wrap gap-3">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-white">Próxima aula</h3>
                    @if($proximaAula)
                        <p class="text-sm text-gray-400">
                            {{ $proximaAula['horario']->dia_semana_label }} ·
                            {{ \Illuminate\Support\Carbon::parse($proximaAula['horario']->hora_inicio)->format('H:i') }} ·
                            {{ $proximaAula['datetime']->format('d/m/Y') }}
                        </p>
                    @else
                        <p class="text-sm text-gray-400">Nenhum horário cadastrado</p>
                    @endif
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('professor.horarios.create') }}"
                   style="background-color: #2563eb; color: #ffffff;"
                   onmouseover="this.style.backgroundColor='#1d4ed8'"
                   onmouseout="this.style.backgroundColor='#2563eb'"
                   class="text-xs font-medium px-3 py-1.5 rounded-md transition-colors">
                    + Horário
                </a>
                <a href="{{ route('professor.treinos.create') }}"
                   style="background-color: #2563eb; color: #ffffff;"
                   onmouseover="this.style.backgroundColor='#1d4ed8'"
                   onmouseout="this.style.backgroundColor='#2563eb'"
                   class="text-xs font-medium px-3 py-1.5 rounded-md transition-colors">
                    + Treino
                </a>
            </div>
        </div>

        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-sm font-semibold text-gray-300 uppercase tracking-wider">Alunos confirmados</h4>
                @if(!empty($alunosProxima))
                    <span class="text-xs text-gray-500">{{ count($alunosProxima) }} {{ count($alunosProxima) === 1 ? 'aluno' : 'alunos' }}</span>
                @endif
            </div>

            @if(empty($alunosProxima))
                <div class="text-center py-10 text-sm text-gray-500">
                    Nenhum aluno marcado ou aprovado neste horário.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3">
                    @foreach($alunosProxima as $a)
                        <button type="button"
                                class="text-left bg-gray-800/40 hover:bg-gray-800/70 border border-gray-700 hover:border-blue-500/50 rounded-lg p-3 transition-all group"
                                onclick="openAlunoModal({ id: {{ $a['id'] }}, name: '{{ $a['name'] }}', email: '{{ $a['email'] }}', numero: {{ $a['proxima_numero'] }}, seq: '{{ addslashes($a['proxima_seq']) }}' })">
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <div class="w-8 h-8 rounded-full bg-linear-to-br from-blue-600 to-blue-800 flex items-center justify-center text-white text-xs font-semibold shrink-0">
                                        {{ mb_strtoupper(mb_substr($a['name'], 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-sm text-white font-medium truncate">{{ $a['name'] }}</div>
                                        <div class="text-xs text-gray-500 truncate">{{ $a['email'] }}</div>
                                    </div>
                                </div>
                                <span class="text-xs font-semibold px-2 py-1 rounded bg-green-500/20 text-green-300 shrink-0">
                                    Aula {{ $a['proxima_numero'] }}
                                </span>
                            </div>
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Ações rápidas --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-white">Atalhos</h3>
                <p class="text-xs text-gray-400">Acesse rapidamente as principais áreas</p>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-2">
            <a href="{{ route('professor.alunos.index') }}"
               class="flex items-center gap-2 px-3 py-2.5 rounded-md bg-gray-800/50 hover:bg-gray-700/60 border border-gray-700 hover:border-blue-500/50 text-sm text-gray-200 transition-all">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" /></svg>
                Alunos
            </a>
            <a href="{{ route('professor.treinos.index') }}"
               class="flex items-center gap-2 px-3 py-2.5 rounded-md bg-gray-800/50 hover:bg-gray-700/60 border border-gray-700 hover:border-blue-500/50 text-sm text-gray-200 transition-all">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                Treinos
            </a>
            <a href="{{ route('professor.aulas-sequencia.index') }}"
               class="flex items-center gap-2 px-3 py-2.5 rounded-md bg-gray-800/50 hover:bg-gray-700/60 border border-gray-700 hover:border-blue-500/50 text-sm text-gray-200 transition-all">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                Sequência
            </a>
            <a href="{{ route('professor.horarios.index') }}"
               class="flex items-center gap-2 px-3 py-2.5 rounded-md bg-gray-800/50 hover:bg-gray-700/60 border border-gray-700 hover:border-blue-500/50 text-sm text-gray-200 transition-all">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z" /></svg>
                Horários
            </a>
            <a href="{{ route('professor.regras.index') }}"
               class="flex items-center gap-2 px-3 py-2.5 rounded-md bg-gray-800/50 hover:bg-gray-700/60 border border-gray-700 hover:border-blue-500/50 text-sm text-gray-200 transition-all">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-7 4h8M5 6h14M7 8h10M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                Regras
            </a>
        </div>
    </div>

    {{-- Modal aluno --}}
    <div id="alunoModal" class="fixed inset-0 z-50 hidden bg-black/70 backdrop-blur-sm">
        <div class="absolute inset-0 flex items-center justify-center p-4" onclick="closeAlunoModal()">
            <div class="bg-gray-900 border border-gray-700 rounded-xl shadow-2xl w-full max-w-2xl" onclick="event.stopPropagation();">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-800">
                    <h3 id="alunoModalTitle" class="text-lg font-semibold text-white">Aluno</h3>
                    <button class="text-gray-400 hover:text-white text-xl leading-none" onclick="closeAlunoModal()">✕</button>
                </div>
                <div class="px-6 py-5 space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-400">Próxima aula</div>
                        <div id="alunoModalAula" class="px-2 py-1 text-xs font-semibold rounded bg-green-500/20 text-green-300">Aula X</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-400 mb-2">Sequência desta aula</div>
                        <div id="alunoModalSeq" class="text-sm text-gray-200 whitespace-pre-line bg-gray-800/50 border border-gray-700 rounded-md p-3">...</div>
                    </div>
                </div>
                <div class="flex justify-end gap-2 px-6 py-4 border-t border-gray-800">
                    <button class="px-4 py-2 rounded-md text-sm border border-gray-700 text-gray-300 hover:bg-gray-800 transition-colors" onclick="closeAlunoModal()">Fechar</button>
                    <a href="{{ route('professor.treinos.create') }}"
                       style="background-color: #2563eb; color: #ffffff;"
                       onmouseover="this.style.backgroundColor='#1d4ed8'"
                       onmouseout="this.style.backgroundColor='#2563eb'"
                       class="px-4 py-2 rounded-md text-sm transition-colors">Registrar Presença</a>
                </div>
            </div>
        </div>
    </div>

    @include('components.pwa-install-prompt')

    <script>
        // Abre o modal preenchendo os dados do aluno selecionado
        function openAlunoModal(data) {
            document.getElementById('alunoModalTitle').textContent = data.name;
            document.getElementById('alunoModalAula').textContent  = 'Aula ' + data.numero;
            document.getElementById('alunoModalSeq').textContent   = data.seq;
            document.getElementById('alunoModal').classList.remove('hidden');
        }
        // Fecha o modal
        function closeAlunoModal() {
            document.getElementById('alunoModal').classList.add('hidden');
        }
    </script>
</div>
@endsection
