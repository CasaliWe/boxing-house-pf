@extends('layouts.app')

@section('title', 'Sequência de Aulas')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="w-full sm:w-auto">
            <h1 class="text-2xl md:text-3xl font-bold text-blue-400">📚 Sequência de Aulas</h1>
            <p class="text-gray-400 text-sm md:text-base">Defina o conteúdo programático das aulas por número.</p>
        </div>
        <a href="{{ route('professor.aulas-sequencia.create') }}" class="bg-gradient-blue text-white px-5 py-3 rounded-lg font-medium w-full sm:w-auto text-center transition duration-150 hover:opacity-95 active:scale-95 focus:outline-none focus:ring-2 focus:ring-blue-500">+ Nova Sequência</a>
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6 overflow-x-auto">
        <table class="w-full table-auto md:table-fixed">
            <thead class="bg-gray-800/60">
                <tr>
                    <th class="text-left px-3 md:px-4 py-3 text-gray-300 md:w-20">Aula</th>
                    <th class="text-left px-3 md:px-4 py-3 text-gray-300">Descrição</th>
                    <th class="text-left px-3 md:px-4 py-3 text-gray-300 md:w-24">Ativo</th>
                    <th class="text-left px-3 md:px-4 py-3 text-gray-300 md:w-64">Ações</th>
                </tr>
            </thead>
            <tbody>
            @forelse($sequencias as $seq)
                <tr class="border-t border-gray-700">
                    <td class="px-3 md:px-4 py-3 text-white align-top md:w-20">{{ $seq->numero }}</td>
                    <td class="px-3 md:px-4 py-3 text-gray-200 break-words whitespace-normal align-top">{{ $seq->descricao }}</td>
                    <td class="px-3 md:px-4 py-3 align-top md:w-24">{!! $seq->ativo ? '<span class="px-2 py-1 text-xs rounded bg-green-700 text-green-100">Sim</span>' : '<span class="px-2 py-1 text-xs rounded bg-gray-600 text-gray-100">Não</span>' !!}</td>
                    <td class="px-3 md:px-4 py-3 align-top md:w-64">
                        <div class="flex items-center gap-2 flex-wrap">
                            @if($seq->video_path)
                                <img src="{{ asset($seq->video_path) }}" alt="Imagem da sequência" class="h-8 w-8 rounded object-cover border border-gray-600">
                            @endif
                            <a href="{{ route('professor.aulas-sequencia.edit', $seq) }}" class="px-3 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white text-sm text-center transition duration-150 active:scale-95 focus:outline-none focus:ring-2 focus:ring-blue-500">Editar</a>
                            <form method="POST" action="{{ route('professor.aulas-sequencia.destroy', $seq) }}" onsubmit="return confirm('Excluir esta sequência?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white text-sm text-center transition duration-150 active:scale-95 focus:outline-none focus:ring-2 focus:ring-red-500">Excluir</button>
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

<!-- Overlay de vídeo (com fundo preto sutil) -->
<div id="modalVideoSequencia" class="fixed inset-0 z-50 hidden bg-black/70">
    <div class="absolute inset-0 flex items-center justify-center" onclick="closeVideoModal()">
        <video id="videoSequencia" controls class="block max-h-[90vh] max-w-[90vw] bg-black rounded" onclick="event.stopPropagation();"></video>
    </div>
</div>
<script>
function abrirModalVideo(src){
    const modal = document.getElementById('modalVideoSequencia');
    const v = document.getElementById('videoSequencia');
    v.src = src;
    modal.classList.remove('hidden');
}
function closeVideoModal() {
    const modal = document.getElementById('modalVideoSequencia');
    const v = document.getElementById('videoSequencia');
    v.pause();
    modal.classList.add('hidden');
}
</script>

    <div>{{ $sequencias->links() }}</div>
</div>
@endsection
