@extends('layouts.app')

@section('title', 'Aulas EXP')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- Cabeçalho da página --}}
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Aulas Experimentais</h1>
            <p class="text-sm text-gray-400 mt-1">Gerencie as aulas experimentais marcadas</p>
        </div>
        <a href="{{ route('professor.aulas-exp.create') }}"
           style="background-color: #2563eb; color: #ffffff;"
           onmouseover="this.style.backgroundColor='#1d4ed8'"
           onmouseout="this.style.backgroundColor='#2563eb'"
           class="inline-flex items-center gap-2 text-sm font-medium px-4 py-2 rounded-md transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nova Aula EXP
        </a>
    </div>

    {{-- Lista --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
            <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-white">Agendamentos</h3>
                <p class="text-xs text-gray-400">Todas as aulas experimentais</p>
            </div>
        </div>

        <div class="p-6">
            @if($aulas->isEmpty())
                <div class="text-center py-12 text-sm text-gray-500">Nenhuma aula experimental cadastrada ainda.</div>
            @else
                <div class="space-y-3">
                    @foreach($aulas as $aula)
                        @php
                            $passada = $aula->data->lt(\Illuminate\Support\Carbon::today());
                            $hoje    = $aula->data->isToday();
                        @endphp
                        <div class="bg-gray-800/40 border border-gray-700 rounded-lg p-4 {{ $passada ? 'opacity-60' : '' }}">
                            <div class="flex items-start justify-between gap-4 flex-col sm:flex-row">
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2 flex-wrap mb-2">
                                        <h3 class="text-base font-semibold text-white">{{ $aula->nome }}</h3>
                                        @if($passada)
                                            <span class="text-xs font-semibold px-2 py-0.5 rounded bg-gray-700 text-gray-300">Passada</span>
                                        @elseif($hoje)
                                            <span class="text-xs font-semibold px-2 py-0.5 rounded bg-green-500/20 text-green-300">Hoje</span>
                                        @else
                                            <span class="text-xs font-semibold px-2 py-0.5 rounded bg-blue-500/20 text-blue-300">Agendada</span>
                                        @endif
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm">
                                        <div>
                                            <div class="text-xs text-gray-500 uppercase tracking-wider">Data</div>
                                            <div class="text-gray-200 mt-0.5">{{ $aula->data->format('d/m/Y') }} ({{ $aula->dia_semana_label }})</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500 uppercase tracking-wider">Horário</div>
                                            <div class="text-gray-200 mt-0.5">{{ \Illuminate\Support\Carbon::parse($aula->horario)->format('H:i') }}</div>
                                        </div>
                                        @if($aula->numero)
                                            <div>
                                                <div class="text-xs text-gray-500 uppercase tracking-wider">Telefone</div>
                                                <div class="text-gray-200 mt-0.5">{{ $aula->numero }}</div>
                                            </div>
                                        @endif
                                    </div>
                                    @if($aula->observacao)
                                        <div class="mt-3 bg-gray-900/40 border border-gray-700 rounded-md p-3">
                                            <div class="text-xs text-gray-500 uppercase tracking-wider mb-1">Observação</div>
                                            <div class="text-sm text-gray-300 whitespace-pre-line">{{ $aula->observacao }}</div>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    <a href="{{ route('professor.aulas-exp.edit', $aula) }}"
                                       style="background-color: #2563eb; color: #ffffff;"
                                       onmouseover="this.style.backgroundColor='#1d4ed8'"
                                       onmouseout="this.style.backgroundColor='#2563eb'"
                                       class="text-xs font-medium px-3 py-1.5 rounded-md transition-colors">
                                        Editar
                                    </a>
                                    <form method="POST" action="{{ route('professor.aulas-exp.destroy', $aula) }}" onsubmit="return confirm('Tem certeza que deseja excluir esta aula EXP?');">
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
