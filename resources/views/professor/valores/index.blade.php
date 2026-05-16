@extends('layouts.app')

@section('title', 'Valores')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- Cabeçalho da página --}}
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Valores por aula</h1>
            <p class="text-sm text-gray-400 mt-1">Cadastre faixas por quantidade de aulas e o valor da experimental</p>
        </div>
        <a href="{{ route('professor.valores.create') }}"
           style="background-color: #2563eb; color: #ffffff;"
           onmouseover="this.style.backgroundColor='#1d4ed8'"
           onmouseout="this.style.backgroundColor='#2563eb'"
           class="inline-flex items-center gap-2 text-sm font-medium px-4 py-2 rounded-md transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Novo valor
        </a>
    </div>

    {{-- Pacotes mensais --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
            <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-2.21 0-4 .9-4 2s1.79 2 4 2 4 .9 4 2-1.79 2-4 2m0-8v10m0-10c1.862 0 3.5.805 3.5 1.8M12 8C10.138 8 8.5 8.805 8.5 9.8" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-white">Pacotes mensais</h3>
                <p class="text-xs text-gray-400">Tabela de valores por faixa de aulas no mês</p>
            </div>
        </div>

        <div class="p-6">
            @if($pacotes->isEmpty())
                <div class="text-center py-10 text-sm text-gray-500">Nenhum pacote cadastrado ainda.</div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    @foreach($pacotes as $valor)
                        <div class="bg-gray-800/40 border border-gray-700 hover:border-blue-500/40 rounded-lg p-4 flex flex-col gap-3 transition-all">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <div class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Até {{ $valor->aulas_mes }} aulas/mês</div>
                                    <div class="text-2xl font-bold text-white mt-1">R$ {{ number_format($valor->valor_aula, 2, ',', '.') }}</div>
                                    <div class="text-xs text-gray-500">por aula</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Total</div>
                                    <div class="text-sm text-green-400 font-semibold mt-1">R$ {{ number_format($valor->valor_total, 2, ',', '.') }}</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 pt-1">
                                <a href="{{ route('professor.valores.edit', $valor) }}"
                                   style="background-color: #2563eb; color: #ffffff;"
                                   onmouseover="this.style.backgroundColor='#1d4ed8'"
                                   onmouseout="this.style.backgroundColor='#2563eb'"
                                   class="flex-1 text-xs font-medium py-1.5 rounded-md transition-colors text-center">
                                    Editar
                                </a>
                                <form method="POST" action="{{ route('professor.valores.destroy', $valor) }}" onsubmit="return confirm('Tem certeza que deseja excluir este valor?');" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            style="background-color: #dc2626; color: #ffffff;"
                                            onmouseover="this.style.backgroundColor='#b91c1c'"
                                            onmouseout="this.style.backgroundColor='#dc2626'"
                                            class="w-full text-xs font-medium py-1.5 rounded-md transition-colors">
                                        Excluir
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Aula experimental --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
            <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-white">Aula experimental</h3>
                <p class="text-xs text-gray-400">Valor cobrado da primeira aula</p>
            </div>
        </div>

        <div class="p-6">
            @if($experimental)
                <div class="bg-blue-500/5 border border-blue-500/40 rounded-lg p-5 flex items-center justify-between gap-4">
                    <div>
                        <div class="text-xs text-blue-300 uppercase tracking-wider font-semibold">Valor da aula experimental</div>
                        <div class="text-3xl font-bold text-white mt-1">R$ {{ number_format($experimental->valor_aula, 2, ',', '.') }}</div>
                    </div>
                    <a href="{{ route('professor.valores.edit', $experimental) }}"
                       style="background-color: #2563eb; color: #ffffff;"
                       onmouseover="this.style.backgroundColor='#1d4ed8'"
                       onmouseout="this.style.backgroundColor='#2563eb'"
                       class="text-sm font-medium px-4 py-2 rounded-md transition-colors">
                        Editar
                    </a>
                </div>
            @else
                <div class="bg-gray-800/40 border border-gray-700 rounded-lg p-5 flex items-center justify-between gap-4">
                    <span class="text-sm text-gray-400">Nenhum valor de aula experimental cadastrado.</span>
                    <a href="{{ route('professor.valores.create') }}"
                       style="background-color: #2563eb; color: #ffffff;"
                       onmouseover="this.style.backgroundColor='#1d4ed8'"
                       onmouseout="this.style.backgroundColor='#2563eb'"
                       class="text-sm font-medium px-4 py-2 rounded-md transition-colors">
                        Cadastrar
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
