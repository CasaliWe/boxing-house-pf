@extends('layouts.app')

@section('title', 'Entradas e Saídas')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- Cabeçalho da página --}}
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Entradas e saídas</h1>
            <p class="text-sm text-gray-400 mt-1">Controle financeiro mensal — {{ ucfirst($mesLabel) }}</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('professor.movimentacoes.create', ['tipo' => 'entrada']) }}"
               style="background-color: #16a34a; color: #ffffff;"
               onmouseover="this.style.backgroundColor='#15803d'"
               onmouseout="this.style.backgroundColor='#16a34a'"
               class="inline-flex items-center gap-2 text-sm font-medium px-3 py-2 rounded-md transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Entrada
            </a>
            <a href="{{ route('professor.movimentacoes.create', ['tipo' => 'saida']) }}"
               style="background-color: #dc2626; color: #ffffff;"
               onmouseover="this.style.backgroundColor='#b91c1c'"
               onmouseout="this.style.backgroundColor='#dc2626'"
               class="inline-flex items-center gap-2 text-sm font-medium px-3 py-2 rounded-md transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Saída
            </a>
        </div>
    </div>

    {{-- Cards de totalizadores --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg p-5">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs text-gray-400 uppercase tracking-wider">Entradas</span>
                <div class="w-8 h-8 rounded-md bg-green-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-green-400">R$ {{ number_format($entradasMes, 2, ',', '.') }}</div>
            <div class="text-xs text-gray-500 mt-1">Total do mês</div>
        </div>

        <div class="bg-gray-900/60 border border-gray-800 rounded-lg p-5">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs text-gray-400 uppercase tracking-wider">Saídas</span>
                <div class="w-8 h-8 rounded-md bg-red-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-red-400">R$ {{ number_format($saidasMes, 2, ',', '.') }}</div>
            <div class="text-xs text-gray-500 mt-1">Total do mês</div>
        </div>

        <div class="bg-gray-900/60 border border-gray-800 rounded-lg p-5">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs text-gray-400 uppercase tracking-wider">Saldo</span>
                <div class="w-8 h-8 rounded-md bg-blue-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-2.21 0-4 .9-4 2s1.79 2 4 2 4 .9 4 2-1.79 2-4 2m0-8v10m0-10c1.862 0 3.5.805 3.5 1.8M12 8C10.138 8 8.5 8.805 8.5 9.8"/></svg>
                </div>
            </div>
            <div class="text-2xl font-bold {{ $saldoMes >= 0 ? 'text-blue-400' : 'text-red-400' }}">R$ {{ number_format($saldoMes, 2, ',', '.') }}</div>
            <div class="text-xs text-gray-500 mt-1">Entradas − Saídas</div>
        </div>

        <div class="bg-gray-900/60 border border-gray-800 rounded-lg p-5">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs text-gray-400 uppercase tracking-wider">Pendências</span>
                <div class="w-8 h-8 rounded-md bg-yellow-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <div class="text-xs text-green-300/80">A receber</div>
                    <div class="text-sm font-semibold text-green-400">R$ {{ number_format($aReceberMes, 2, ',', '.') }}</div>
                </div>
                <div>
                    <div class="text-xs text-red-300/80">A pagar</div>
                    <div class="text-sm font-semibold text-red-400">R$ {{ number_format($aPagarMes, 2, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('professor.movimentacoes.index') }}" class="bg-gray-900/60 border border-gray-800 rounded-lg p-4">
        <div class="flex flex-wrap items-end gap-3">
            <div>
                <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Mês</label>
                <input type="month" name="mes" value="{{ $mesFiltro }}"
                       class="bg-gray-800 border border-gray-700 rounded-md px-3 py-1.5 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Tipo</label>
                <select name="tipo" class="bg-gray-800 border border-gray-700 rounded-md px-3 py-1.5 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Todos</option>
                    <option value="entrada" {{ $tipoFiltro === 'entrada' ? 'selected' : '' }}>Entradas</option>
                    <option value="saida"   {{ $tipoFiltro === 'saida'   ? 'selected' : '' }}>Saídas</option>
                </select>
            </div>
            <div>
                <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Status</label>
                <select name="status" class="bg-gray-800 border border-gray-700 rounded-md px-3 py-1.5 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Todos</option>
                    <option value="aberto" {{ $statusFiltro === 'aberto' ? 'selected' : '' }}>Em aberto</option>
                    <option value="atraso" {{ $statusFiltro === 'atraso' ? 'selected' : '' }}>Em atraso</option>
                    <option value="pago"   {{ $statusFiltro === 'pago'   ? 'selected' : '' }}>Pago</option>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <button type="submit"
                        style="background-color: #2563eb; color: #ffffff;"
                        onmouseover="this.style.backgroundColor='#1d4ed8'"
                        onmouseout="this.style.backgroundColor='#2563eb'"
                        class="text-xs font-medium px-4 py-1.5 rounded-md transition-colors">
                    Filtrar
                </button>
                @if($tipoFiltro || $statusFiltro)
                    <a href="{{ route('professor.movimentacoes.index', ['mes' => $mesFiltro]) }}"
                       class="text-xs font-medium px-4 py-1.5 rounded-md border border-gray-700 text-gray-300 hover:bg-gray-800 transition-colors">
                        Limpar
                    </a>
                @endif
            </div>
        </div>
    </form>

    {{-- Tabela de movimentações --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
            <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-7v14m-7 0h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-white">Movimentações</h3>
                <p class="text-xs text-gray-400">{{ $movimentacoes->total() }} {{ $movimentacoes->total() === 1 ? 'registro' : 'registros' }} no período</p>
            </div>
        </div>

        @if($movimentacoes->isEmpty())
            <div class="p-12 text-center text-sm text-gray-500">Nenhuma movimentação encontrada para esse filtro.</div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-900/40 border-b border-gray-800">
                        <tr>
                            <th class="text-left px-6 py-3 text-xs text-gray-400 uppercase tracking-wider font-semibold w-24">Tipo</th>
                            <th class="text-left px-6 py-3 text-xs text-gray-400 uppercase tracking-wider font-semibold">Descrição</th>
                            <th class="text-left px-6 py-3 text-xs text-gray-400 uppercase tracking-wider font-semibold">Aluno</th>
                            <th class="text-left px-6 py-3 text-xs text-gray-400 uppercase tracking-wider font-semibold w-32">Vencimento</th>
                            <th class="text-right px-6 py-3 text-xs text-gray-400 uppercase tracking-wider font-semibold w-32">Valor</th>
                            <th class="text-left px-6 py-3 text-xs text-gray-400 uppercase tracking-wider font-semibold w-28">Status</th>
                            <th class="text-right px-6 py-3 text-xs text-gray-400 uppercase tracking-wider font-semibold w-44">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($movimentacoes as $mov)
                            <tr class="border-b border-gray-800 hover:bg-gray-800/30">
                                <td class="px-6 py-3 align-top">
                                    @if($mov->tipo === 'entrada')
                                        <span class="inline-block whitespace-nowrap text-xs font-semibold px-2 py-1 rounded bg-green-500/20 text-green-300">Entrada</span>
                                    @else
                                        <span class="inline-block whitespace-nowrap text-xs font-semibold px-2 py-1 rounded bg-red-500/20 text-red-300">Saída</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 align-top">
                                    <div class="text-sm font-medium text-white">{{ $mov->descricao }}</div>
                                    @if($mov->observacoes)
                                        <div class="text-xs text-gray-500 mt-0.5 line-clamp-2">{{ $mov->observacoes }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-3 align-top">
                                    @if($mov->user)
                                        <div class="text-sm text-gray-200">{{ $mov->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $mov->user->email }}</div>
                                    @else
                                        <span class="text-xs text-gray-500">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 align-top text-sm text-gray-300">
                                    {{ $mov->data_vencimento?->format('d/m/Y') }}
                                    @if($mov->data_pagamento)
                                        <div class="text-xs text-green-400">Pago em {{ $mov->data_pagamento->format('d/m/Y') }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-3 align-top text-right">
                                    <span class="text-sm font-semibold {{ $mov->tipo === 'entrada' ? 'text-green-400' : 'text-red-400' }}">
                                        R$ {{ number_format((float)$mov->valor, 2, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 align-top">
                                    <span class="inline-block whitespace-nowrap text-xs font-semibold px-2 py-1 rounded {{ $mov->status_cor }}">{{ $mov->status_label }}</span>
                                </td>
                                <td class="px-6 py-3 align-top">
                                    <div class="flex items-center gap-2 justify-end">
                                        @if($mov->status !== 'pago')
                                            <form method="POST" action="{{ route('professor.movimentacoes.pago', $mov) }}">
                                                @csrf
                                                <button type="submit"
                                                        style="background-color: #16a34a; color: #ffffff;"
                                                        onmouseover="this.style.backgroundColor='#15803d'"
                                                        onmouseout="this.style.backgroundColor='#16a34a'"
                                                        class="text-xs font-medium px-2.5 py-1.5 rounded-md transition-colors">
                                                    Pagar
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('professor.movimentacoes.edit', $mov) }}"
                                           style="background-color: #2563eb; color: #ffffff;"
                                           onmouseover="this.style.backgroundColor='#1d4ed8'"
                                           onmouseout="this.style.backgroundColor='#2563eb'"
                                           class="text-xs font-medium px-2.5 py-1.5 rounded-md transition-colors">
                                            Editar
                                        </a>
                                        <form method="POST" action="{{ route('professor.movimentacoes.destroy', $mov) }}" onsubmit="return confirm('Excluir esta movimentação?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    style="background-color: #dc2626; color: #ffffff;"
                                                    onmouseover="this.style.backgroundColor='#b91c1c'"
                                                    onmouseout="this.style.backgroundColor='#dc2626'"
                                                    class="text-xs font-medium px-2.5 py-1.5 rounded-md transition-colors">
                                                Excluir
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($movimentacoes->hasPages())
                <div class="px-6 py-4 border-t border-gray-800">{{ $movimentacoes->links() }}</div>
            @endif
        @endif
    </div>
</div>
@endsection
