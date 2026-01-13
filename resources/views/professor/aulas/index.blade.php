@extends('layouts.app')

@section('title', 'Sequência de Aulas')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between flex-col gap-4 sm:flex-row">
        <div>
            <h1 class="text-3xl font-bold text-blue-400">📚 Sequência de Aulas</h1>
            <p class="text-gray-400">Defina o conteúdo programático das aulas por número.</p>
        </div>
        <a href="{{ route('professor.aulas-sequencia.create') }}" class="bg-gradient-blue text-white px-5 py-3 rounded-lg font-medium hover:opacity-95 transition">+ Nova Sequência</a>
    </div>

    @if(session('success'))
        <div class="p-3 rounded-lg border border-green-600 bg-green-800/30 text-green-100">{{ session('success') }}</div>
    @endif

    <div class="bg-gradient-card border border-gray-600 rounded-xl overflow-x-auto">
        <table class="min-w-[720px]">
            <thead class="bg-gray-800/60">
                <tr>
                    <th class="text-left px-4 py-3 text-gray-300">Aula</th>
                    <th class="text-left px-4 py-3 text-gray-300">Descrição</th>
                    <th class="text-left px-4 py-3 text-gray-300">Ativo</th>
                    <th class="text-left px-4 py-3 text-gray-300">Ações</th>
                </tr>
            </thead>
            <tbody>
            @forelse($sequencias as $seq)
                <tr class="border-t border-gray-700">
                    <td class="px-4 py-3 text-white">{{ $seq->numero }}</td>
                    <td class="px-4 py-3 text-gray-200 break-words">{{ $seq->descricao }}</td>
                    <td class="px-4 py-3">{!! $seq->ativo ? '<span class="px-2 py-1 text-xs rounded bg-green-700 text-green-100">Sim</span>' : '<span class="px-2 py-1 text-xs rounded bg-gray-600 text-gray-100">Não</span>' !!}</td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('professor.aulas-sequencia.edit', $seq) }}" class="px-3 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white text-sm">Editar</a>
                            <form method="POST" action="{{ route('professor.aulas-sequencia.destroy', $seq) }}" onsubmit="return confirm('Excluir esta sequência?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white text-sm">Excluir</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-6 text-gray-300 text-center">Nenhuma sequência cadastrada.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $sequencias->links() }}</div>
</div>
@endsection
