@extends('layouts.app')

@section('title', 'Treinos')

@section('content')
@php
    // Estatísticas calculadas a partir da página atual
    $totalNaPagina = $treinos->count();
    $especiaisNaPagina   = $treinos->where('especial', true)->count();
    $sequenciaisNaPagina = $totalNaPagina - $especiaisNaPagina;
    $totalAlunosPresencas = $treinos->sum('alunos_count');
    // Garante que cada treino traga seus alunos para listar nomes
    $treinos->load('alunos:id,name');
@endphp

<div class="max-w-7xl mx-auto space-y-6">

    {{-- Cabeçalho da página --}}
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Treinos</h1>
            <p class="text-sm text-gray-400 mt-1">Registre foto, data e marque os alunos presentes</p>
        </div>
        <a href="{{ route('professor.treinos.create') }}"
           style="background-color: #2563eb; color: #ffffff;"
           onmouseover="this.style.backgroundColor='#1d4ed8'"
           onmouseout="this.style.backgroundColor='#2563eb'"
           class="inline-flex items-center gap-2 text-sm font-medium px-4 py-2 rounded-md transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Novo treino
        </a>
    </div>

    {{-- Estatísticas --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg p-5">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs text-gray-400 uppercase tracking-wider">Nesta página</span>
                <div class="w-8 h-8 rounded-md bg-blue-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-white">{{ $totalNaPagina }}</div>
            <div class="text-xs text-gray-500 mt-1">Treinos exibidos</div>
        </div>
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg p-5">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs text-gray-400 uppercase tracking-wider">Sequenciais</span>
                <div class="w-8 h-8 rounded-md bg-green-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-green-400">{{ $sequenciaisNaPagina }}</div>
            <div class="text-xs text-gray-500 mt-1">Da progressão</div>
        </div>
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg p-5">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs text-gray-400 uppercase tracking-wider">Especiais</span>
                <div class="w-8 h-8 rounded-md bg-purple-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-purple-400">{{ $especiaisNaPagina }}</div>
            <div class="text-xs text-gray-500 mt-1">Aulas extras / eventos</div>
        </div>
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg p-5">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs text-gray-400 uppercase tracking-wider">Presenças</span>
                <div class="w-8 h-8 rounded-md bg-blue-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-blue-400">{{ $totalAlunosPresencas }}</div>
            <div class="text-xs text-gray-500 mt-1">Alunos somados</div>
        </div>
    </div>

    {{-- Lista --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
            <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-white">Histórico de treinos</h3>
                <p class="text-xs text-gray-400">Ordenados do mais recente ao mais antigo</p>
            </div>
        </div>

        <div class="p-6">
            @if($treinos->isEmpty())
                <div class="text-center py-12 text-sm text-gray-500">
                    Nenhum treino cadastrado ainda.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    @foreach($treinos as $treino)
                        <div class="bg-gray-800/40 border border-gray-700 hover:border-blue-500/40 rounded-lg overflow-hidden flex flex-col transition-all">
                            {{-- Foto --}}
                            <div class="aspect-video bg-gray-900 overflow-hidden relative">
                                <img src="{{ asset($treino->foto_path) }}" alt="Foto do treino" class="w-full h-full object-cover">
                                @if($treino->especial)
                                    <span class="absolute top-2 left-2 text-xs font-semibold px-2 py-1 rounded bg-purple-500/30 text-purple-200 backdrop-blur-sm border border-purple-400/30">Especial</span>
                                @else
                                    <span class="absolute top-2 left-2 text-xs font-semibold px-2 py-1 rounded bg-green-500/30 text-green-200 backdrop-blur-sm border border-green-400/30">Sequencial</span>
                                @endif
                                <span class="absolute top-2 right-2 text-xs font-semibold px-2 py-1 rounded bg-black/60 text-white backdrop-blur-sm">
                                    {{ $treino->alunos_count }} {{ $treino->alunos_count === 1 ? 'aluno' : 'alunos' }}
                                </span>
                            </div>

                            <div class="p-4 flex flex-col gap-3 flex-1">
                                {{-- Data --}}
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-xs text-gray-500 uppercase tracking-wider">Data</div>
                                        <div class="text-sm font-semibold text-white mt-0.5">{{ $treino->data->format('d/m/Y') }}</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xs text-gray-500 uppercase tracking-wider">Dia</div>
                                        <div class="text-sm text-gray-200 mt-0.5">{{ ucfirst($treino->data->locale('pt_BR')->isoFormat('dddd')) }}</div>
                                    </div>
                                </div>

                                {{-- Lista de alunos --}}
                                <div class="bg-gray-900/40 border border-gray-700 rounded-md p-3 flex-1">
                                    <div class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1.5">Presentes</div>
                                    @if($treino->alunos->isEmpty())
                                        <div class="text-xs text-gray-500 italic">Nenhum aluno marcado</div>
                                    @else
                                        <div class="flex flex-wrap gap-1.5">
                                            @foreach($treino->alunos->take(6) as $aluno)
                                                <span class="text-xs bg-gray-700/60 text-gray-200 rounded px-2 py-0.5 truncate max-w-35">
                                                    {{ \Illuminate\Support\Str::limit($aluno->name, 18) }}
                                                </span>
                                            @endforeach
                                            @if($treino->alunos->count() > 6)
                                                <span class="text-xs text-gray-400 px-2 py-0.5">+{{ $treino->alunos->count() - 6 }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                {{-- Ações --}}
                                <div class="grid grid-cols-3 gap-2 pt-1">
                                    <a href="{{ route('professor.treinos.show', $treino) }}"
                                       class="text-xs font-medium py-2 rounded-md border border-gray-700 text-gray-300 hover:bg-gray-800 transition-colors text-center">
                                        Ver
                                    </a>
                                    <a href="{{ route('professor.treinos.edit', $treino) }}"
                                       style="background-color: #2563eb; color: #ffffff;"
                                       onmouseover="this.style.backgroundColor='#1d4ed8'"
                                       onmouseout="this.style.backgroundColor='#2563eb'"
                                       class="text-xs font-medium py-2 rounded-md transition-colors text-center">
                                        Editar
                                    </a>
                                    <form method="POST" action="{{ route('professor.treinos.destroy', $treino) }}" onsubmit="return confirm('Excluir este treino?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                style="background-color: #dc2626; color: #ffffff;"
                                                onmouseover="this.style.backgroundColor='#b91c1c'"
                                                onmouseout="this.style.backgroundColor='#dc2626'"
                                                class="w-full text-xs font-medium py-2 rounded-md transition-colors">
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">{{ $treinos->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
