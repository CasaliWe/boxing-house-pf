@extends('layouts.app')

@section('title', 'Aulas EXP')

@section('content')
<div class="space-y-8">
    <!-- Cabeçalho -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="w-full sm:w-auto">
            <h1 class="text-2xl md:text-3xl font-bold text-blue-400">🥊 Aulas EXP</h1>
            <p class="text-gray-400 text-sm md:text-base">Gerencie as aulas experimentais marcadas.</p>
        </div>
        <a href="{{ route('professor.aulas-exp.create') }}" class="bg-gradient-blue text-white px-5 py-3 rounded-lg font-medium hover:opacity-95 transition w-full sm:w-auto text-center">
            + Nova Aula EXP
        </a>
    </div>

    <!-- Lista -->
    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        @if($aulas->isEmpty())
            <div class="text-center py-12 text-gray-300">Nenhuma aula experimental cadastrada ainda.</div>
        @else
            <div class="space-y-4">
                @foreach($aulas as $aula)
                    @php
                        $passada = $aula->data->lt(\Illuminate\Support\Carbon::today());
                    @endphp
                    <div class="border border-gray-600 rounded-lg p-5 bg-gray-800/40 {{ $passada ? 'opacity-60' : '' }}">
                        <div class="flex items-start justify-between gap-4 flex-col sm:flex-row">
                            <div class="min-w-0 w-full sm:w-auto">
                                <div class="flex items-center gap-3 flex-wrap">
                                    <h3 class="text-lg font-semibold text-white">{{ $aula->nome }}</h3>
                                    @if($passada)
                                        <span class="px-2 py-1 text-xs rounded bg-gray-600 text-gray-100">Passada</span>
                                    @elseif($aula->data->isToday())
                                        <span class="px-2 py-1 text-xs rounded bg-green-700 text-green-100">Hoje</span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded bg-blue-700 text-blue-100">Agendada</span>
                                    @endif
                                </div>
                                <div class="mt-2 space-y-1">
                                    <div class="text-gray-300 text-sm">
                                        📅 {{ $aula->data->format('d/m/Y') }} ({{ $aula->dia_semana_label }})
                                    </div>
                                    <div class="text-gray-300 text-sm">
                                        ⏰ {{ \Illuminate\Support\Carbon::parse($aula->horario)->format('H:i') }}
                                    </div>
                                    @if($aula->numero)
                                        <div class="text-gray-300 text-sm">📞 {{ $aula->numero }}</div>
                                    @endif
                                    @if($aula->observacao)
                                        <div class="text-gray-400 text-sm mt-1 whitespace-pre-line">{{ $aula->observacao }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0 mt-3 sm:mt-0">
                                <a href="{{ route('professor.aulas-exp.edit', $aula) }}" class="px-3 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white text-sm">Editar</a>
                                <form method="POST" action="{{ route('professor.aulas-exp.destroy', $aula) }}" onsubmit="return confirm('Tem certeza que deseja excluir esta aula EXP?');">
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
