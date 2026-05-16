@extends('layouts.app')

@section('title', 'Horários')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- Cabeçalho da página --}}
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Horários</h1>
            <p class="text-sm text-gray-400 mt-1">Gerencie dias, horários e vagas das turmas</p>
        </div>
        <a href="{{ route('professor.horarios.create') }}"
           style="background-color: #2563eb; color: #ffffff;"
           onmouseover="this.style.backgroundColor='#1d4ed8'"
           onmouseout="this.style.backgroundColor='#2563eb'"
           class="inline-flex items-center gap-2 text-sm font-medium px-4 py-2 rounded-md transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Novo horário
        </a>
    </div>

    {{-- Lista --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
            <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-white">Turmas configuradas</h3>
                <p class="text-xs text-gray-400">Todos os horários disponíveis para os alunos escolherem</p>
            </div>
        </div>

        <div class="p-6">
            @if($horarios->isEmpty())
                <div class="text-center py-12 text-sm text-gray-500">
                    Nenhum horário cadastrado ainda. Clique em "Novo horário" para começar.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    @foreach($horarios as $horario)
                        @php $temVaga = $horario->vagas_disponiveis > 0; @endphp
                        <div class="bg-gray-800/40 border border-gray-700 hover:border-blue-500/40 rounded-lg p-4 flex flex-col gap-3 transition-all">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wider font-semibold">{{ $horario->dia_semana_label }}</div>
                                    <div class="text-lg font-semibold text-white mt-0.5">
                                        {{ \Illuminate\Support\Carbon::parse($horario->hora_inicio)->format('H:i') }}
                                        <span class="text-gray-500">–</span>
                                        {{ \Illuminate\Support\Carbon::parse($horario->hora_fim)->format('H:i') }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Ocupação</div>
                                    <div class="text-lg font-bold text-blue-400">{{ $horario->alunos->count() }}<span class="text-gray-500 text-sm font-medium">/{{ $horario->limite_alunos }}</span></div>
                                </div>
                            </div>

                            <div class="bg-gray-900/40 border border-gray-700 rounded-md p-3">
                                <div class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1.5">Inscritos</div>
                                @if($horario->alunos->isEmpty())
                                    <div class="text-xs text-gray-500 italic">Nenhum aluno inscrito</div>
                                @else
                                    <ul class="text-xs text-gray-200 space-y-0.5">
                                        @foreach($horario->alunos as $aluno)
                                            <li class="truncate">· {{ $aluno->name }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>

                            <div class="flex items-center justify-between pt-1">
                                <span class="text-xs font-semibold px-2 py-1 rounded {{ $temVaga ? 'bg-green-500/20 text-green-300' : 'bg-red-500/20 text-red-300' }}">
                                    {{ $temVaga ? $horario->vagas_disponiveis . ' vaga(s)' : 'Sem vagas' }}
                                </span>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('professor.horarios.edit', $horario) }}"
                                       style="background-color: #2563eb; color: #ffffff;"
                                       onmouseover="this.style.backgroundColor='#1d4ed8'"
                                       onmouseout="this.style.backgroundColor='#2563eb'"
                                       class="text-xs font-medium px-3 py-1.5 rounded-md transition-colors">
                                        Editar
                                    </a>
                                    <form method="POST" action="{{ route('professor.horarios.destroy', $horario) }}" onsubmit="return confirm('Tem certeza que deseja excluir este horário?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                style="background-color: #dc2626; color: #ffffff;"
                                                onmouseover="this.style.backgroundColor='#b91c1c'"
                                                onmouseout="this.style.backgroundColor='#dc2626'"
                                                class="text-xs font-medium px-3 py-1.5 rounded-md transition-colors">
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
