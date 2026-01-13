@extends('layouts.app')

@section('title', 'Dashboard Professor')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="text-center">
        <h1 class="text-3xl font-bold text-blue-400 mb-2">🥊 Dashboard Professor</h1>
        <p class="text-gray-400">Painel administrativo da Boxing House PF</p>
    </div>

    <!-- Stats de alunos -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-card border border-gray-600 rounded-xl p-6 text-center">
            <div class="text-gray-300 text-sm mb-2">Total de alunos</div>
            <div class="text-white text-4xl font-bold">{{ $totalAlunos }}</div>
        </div>
        <div class="bg-gradient-card border border-gray-600 rounded-xl p-6 text-center">
            <div class="text-gray-300 text-sm mb-2">Ativos</div>
            <div class="text-green-400 text-4xl font-bold">{{ $alunosAtivos }}</div>
        </div>
        <div class="bg-gradient-card border border-gray-600 rounded-xl p-6 text-center">
            <div class="text-gray-300 text-sm mb-2">Inativos</div>
            <div class="text-yellow-400 text-4xl font-bold">{{ $alunosInativos }}</div>
        </div>
        <div class="bg-gradient-card border border-gray-600 rounded-xl p-6 text-center">
            <div class="text-gray-300 text-sm mb-2">Pendentes</div>
            <div class="text-purple-400 text-4xl font-bold">{{ $alunosPendentes }}</div>
        </div>
    </div>

    <!-- Próxima aula -->
    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h3 class="text-xl font-bold text-blue-400">Próxima aula</h3>
                @if($proximaAula)
                    <p class="text-gray-300">{{ $proximaAula['horario']->dia_semana_label }} — {{ \Illuminate\Support\Carbon::parse($proximaAula['horario']->hora_inicio)->format('H:i') }} ({{ $proximaAula['datetime']->format('d/m/Y') }})</p>
                @else
                    <p class="text-gray-300">Nenhum horário cadastrado</p>
                @endif
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('professor.horarios.index') }}" class="px-4 py-2 rounded-lg border border-gray-600 text-gray-200 hover:bg-gray-700">Gerenciar Horários</a>
                <a href="{{ route('professor.treinos.create') }}" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white">Registrar Treino</a>
            </div>
        </div>

        <div class="mt-6">
            <h4 class="text-lg font-semibold text-white mb-3">Alunos que irão participar</h4>
            @if(empty($alunosProxima))
                <div class="text-gray-300">Nenhum aluno marcado/aprovado neste horário.</div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3">
                    @foreach($alunosProxima as $a)
                        <button type="button" class="text-left border border-gray-600 rounded p-3 bg-gray-800/40 hover:bg-gray-800/60"
                                onclick="openAlunoModal({ id: {{ $a['id'] }}, name: '{{ $a['name'] }}', email: '{{ $a['email'] }}', numero: {{ $a['proxima_numero'] }}, seq: '{{ addslashes($a['proxima_seq']) }}' })">
                            <div class="flex items-center justify-between">
                                <div class="text-white font-semibold truncate">{{ $a['name'] }}</div>
                                <span class="px-2 py-1 text-xs rounded bg-green-700 text-green-100">Aula {{ $a['proxima_numero'] }}</span>
                            </div>
                            <div class="text-gray-400 text-xs mt-1 truncate">{{ $a['email'] }}</div>
                        </button>
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
                <a href="{{ route('professor.alunos.index') }}" class="px-4 py-2 rounded-lg border border-gray-600 text-gray-200 hover:bg-gray-700">Alunos</a>
                <a href="{{ route('professor.treinos.index') }}" class="px-4 py-2 rounded-lg border border-gray-600 text-gray-200 hover:bg-gray-700">Treinos</a>
                <a href="{{ route('professor.aulas-sequencia.index') }}" class="px-4 py-2 rounded-lg border border-gray-600 text-gray-200 hover:bg-gray-700">Sequência de Aulas</a>
                <a href="{{ route('professor.horarios.index') }}" class="px-4 py-2 rounded-lg border border-gray-600 text-gray-200 hover:bg-gray-700">Horários</a>
                <a href="{{ route('professor.regras.index') }}" class="px-4 py-2 rounded-lg border border-gray-600 text-gray-200 hover:bg-gray-700">Regras</a>
            </div>
        </div>
    </div>

    <!-- Modal aluno -->
    <div id="alunoModal" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50">
        <div class="bg-gray-900 border border-gray-700 rounded-xl w-full max-w-lg p-6">
            <div class="flex items-center justify-between">
                <h3 id="alunoModalTitle" class="text-xl font-bold text-blue-400">Aluno</h3>
                <button class="text-gray-300 hover:text-white" onclick="closeAlunoModal()">✖</button>
            </div>
            <div class="mt-4 space-y-3">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-400">Próxima aula</div>
                    <div id="alunoModalAula" class="px-2 py-1 text-xs rounded bg-green-700 text-green-100">Aula X</div>
                </div>
                <div>
                    <div class="text-sm text-gray-400">Sequência desta aula</div>
                    <div id="alunoModalSeq" class="text-gray-200">...</div>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-2">
                <a href="{{ route('professor.treinos.create') }}" class="px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white">Registrar Presença</a>
                <button class="px-4 py-2 rounded-md border border-gray-600 text-gray-200 hover:bg-gray-700" onclick="closeAlunoModal()">Fechar</button>
            </div>
        </div>
    </div>

    <script>
        function openAlunoModal(data) {
            document.getElementById('alunoModalTitle').textContent = data.name;
            document.getElementById('alunoModalAula').textContent = 'Aula ' + data.numero;
            document.getElementById('alunoModalSeq').textContent = data.seq;
            const m = document.getElementById('alunoModal');
            m.classList.remove('hidden');
            m.classList.add('flex');
        }
        function closeAlunoModal() {
            const m = document.getElementById('alunoModal');
            m.classList.add('hidden');
            m.classList.remove('flex');
        }
    </script>
</div>
@endsection