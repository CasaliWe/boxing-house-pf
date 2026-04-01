@extends('layouts.app')

@section('title', 'Horários')

@section('content')
<div class="space-y-8">
    <!-- Cabeçalho -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="w-full sm:w-auto">
            <h1 class="text-2xl md:text-3xl font-bold text-blue-400">📅 Horários</h1>
            <p class="text-gray-400 text-sm md:text-base">Gerencie dias, horários e vagas disponíveis das turmas.</p>
        </div>
        <a href="{{ route('professor.horarios.create') }}" class="bg-gradient-blue text-white px-5 py-3 rounded-lg font-medium hover:opacity-95 transition w-full sm:w-auto text-center">
            + Novo Horário
        </a>
    </div>

    <!-- Lista de Horários -->
    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        @if($horarios->isEmpty())
            <div class="text-center py-12 text-gray-300">
                Nenhum horário cadastrado ainda. Clique em "Novo Horário" para começar.
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($horarios as $horario)
                    <div class="border border-gray-600 rounded-lg p-5 bg-gray-800/40">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="text-sm text-gray-400">{{ $horario->dia_semana_label }}</div>
                                <div class="text-xl font-semibold text-white">
                                    {{ \Illuminate\Support\Carbon::parse($horario->hora_inicio)->format('H:i') }} - 
                                    {{ \Illuminate\Support\Carbon::parse($horario->hora_fim)->format('H:i') }}
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-gray-300 text-sm">Alunos</div>
                                <div class="text-blue-400 text-2xl font-bold">{{ $horario->alunos->count() }} / {{ $horario->limite_alunos }}</div>
                            </div>
                        </div>

                        @if($horario->alunos->isNotEmpty())
                            <div class="mt-4">
                                <div class="text-gray-400 text-sm mb-1">Inscritos:</div>
                                <ul class="list-disc list-inside text-gray-200 text-sm">
                                    @foreach($horario->alunos as $aluno)
                                        <li>{{ $aluno->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <div class="mt-4 text-gray-400 text-sm">Nenhum aluno inscrito ainda.</div>
                        @endif

                        <div class="mt-5 flex items-center justify-between">
                            <div class="text-sm {{ $horario->vagas_disponiveis > 0 ? 'text-green-400' : 'text-red-400' }}">
                                {{ $horario->vagas_disponiveis > 0 ? $horario->vagas_disponiveis . ' vaga(s) disponível(is)' : 'Sem vagas' }}
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('professor.horarios.edit', $horario) }}" class="px-3 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white text-sm">Editar</a>
                                <form method="POST" action="{{ route('professor.horarios.destroy', $horario) }}" onsubmit="return confirm('Tem certeza que deseja excluir este horário?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white text-sm">Excluir</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
