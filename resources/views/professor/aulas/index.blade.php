@extends('layouts.app')

@section('title', 'Sequência de Aulas')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- Cabeçalho da página --}}
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Sequência de aulas</h1>
            <p class="text-sm text-gray-400 mt-1">Defina o conteúdo programático das aulas por número</p>
        </div>
        <a href="{{ route('professor.aulas-sequencia.create') }}"
           style="background-color: #2563eb; color: #ffffff;"
           onmouseover="this.style.backgroundColor='#1d4ed8'"
           onmouseout="this.style.backgroundColor='#2563eb'"
           class="inline-flex items-center gap-2 text-sm font-medium px-4 py-2 rounded-md transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nova sequência
        </a>
    </div>

    {{-- Lista em tabela --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
            <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-white">Conteúdo programático</h3>
                <p class="text-xs text-gray-400">Cada aula da progressão</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-900/40 border-b border-gray-800">
                    <tr>
                        <th class="text-left px-6 py-3 text-xs text-gray-400 uppercase tracking-wider font-semibold w-24">Aula</th>
                        <th class="text-left px-6 py-3 text-xs text-gray-400 uppercase tracking-wider font-semibold w-20">Imagem</th>
                        <th class="text-left px-6 py-3 text-xs text-gray-400 uppercase tracking-wider font-semibold">Descrição</th>
                        <th class="text-left px-6 py-3 text-xs text-gray-400 uppercase tracking-wider font-semibold w-24">Status</th>
                        <th class="text-right px-6 py-3 text-xs text-gray-400 uppercase tracking-wider font-semibold w-48">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sequencias as $seq)
                        <tr class="border-b border-gray-800 hover:bg-gray-800/30">
                            <td class="px-6 py-3 align-top">
                                <span class="inline-block whitespace-nowrap text-xs font-semibold px-2 py-1 rounded bg-blue-500/20 text-blue-300">Aula {{ $seq->numero }}</span>
                            </td>
                            <td class="px-6 py-3 align-top">
                                @if($seq->video_path)
                                    <img src="{{ asset($seq->video_path) }}" alt="Imagem" class="h-10 w-10 rounded object-cover border border-gray-700">
                                @else
                                    <span class="text-xs text-gray-500">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 align-top">
                                <div class="text-sm text-gray-200 wrap-break-word whitespace-normal max-w-2xl">{{ $seq->descricao }}</div>
                            </td>
                            <td class="px-6 py-3 align-top">
                                @if($seq->ativo)
                                    <span class="text-xs font-semibold px-2 py-1 rounded bg-green-500/20 text-green-300">Ativo</span>
                                @else
                                    <span class="text-xs font-semibold px-2 py-1 rounded bg-gray-700 text-gray-300">Inativo</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 align-top">
                                <div class="flex items-center gap-2 justify-end">
                                    <a href="{{ route('professor.aulas-sequencia.edit', $seq) }}"
                                       style="background-color: #2563eb; color: #ffffff;"
                                       onmouseover="this.style.backgroundColor='#1d4ed8'"
                                       onmouseout="this.style.backgroundColor='#2563eb'"
                                       class="text-xs font-medium px-3 py-1.5 rounded-md transition-colors">
                                        Editar
                                    </a>
                                    <form method="POST" action="{{ route('professor.aulas-sequencia.destroy', $seq) }}" onsubmit="return confirm('Excluir esta sequência?')" class="inline">
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
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">Nenhuma sequência cadastrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sequencias->hasPages())
            <div class="px-6 py-4 border-t border-gray-800">{{ $sequencias->links() }}</div>
        @endif
    </div>
</div>
@endsection
