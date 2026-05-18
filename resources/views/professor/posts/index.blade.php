@extends('layouts.app')

@section('title', 'Posts')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Posts</h1>
            <p class="text-sm text-gray-400 mt-1">Gerencie posts, videos e slides planejados para o Instagram</p>
        </div>
        <a href="{{ route('professor.posts.create') }}"
           style="background-color: #2563eb; color: #ffffff;"
           onmouseover="this.style.backgroundColor='#1d4ed8'"
           onmouseout="this.style.backgroundColor='#2563eb'"
           class="inline-flex items-center justify-center gap-2 text-sm font-medium px-4 py-2 rounded-md transition-colors w-full sm:w-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Novo post
        </a>
    </div>

    @if($posts->isEmpty())
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg p-10 text-center">
            <div class="text-gray-300 font-semibold">Nenhum post cadastrado.</div>
            <div class="text-sm text-gray-500 mt-1">Crie o primeiro planejamento acima.</div>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            @foreach($posts as $post)
                <div class="bg-gray-900/60 border border-gray-800 rounded-lg p-5 space-y-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <span class="text-xs font-semibold uppercase tracking-wider px-2 py-1 rounded bg-blue-500/10 text-blue-300">
                                    {{ $post->tipo_label }}
                                </span>
                                <span class="text-xs text-gray-400">
                                    {{ $post->data_postagem->format('d/m/Y H:i') }}
                                </span>
                            </div>
                            <h2 class="text-lg font-semibold text-white break-words">{{ $post->titulo }}</h2>
                        </div>
                    </div>

                    @if($post->legenda)
                        <div class="text-sm text-gray-300 whitespace-pre-line break-words line-clamp-5">{{ $post->legenda }}</div>
                    @endif

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @forelse($post->arquivos ?? [] as $arquivo)
                            @php
                                $nomeArquivo = $arquivo['nome'] ?? basename($arquivo['caminho']);
                                $urlArquivo = asset($arquivo['caminho']);
                                $extensao = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));
                                $ehImagem = in_array($extensao, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'], true);
                                $ehVideo = in_array($extensao, ['mp4', 'mov', 'webm', 'avi', 'mkv'], true);
                            @endphp
                            <a href="{{ asset($arquivo['caminho']) }}" target="_blank"
                               class="group block bg-gray-800/60 border border-gray-700 hover:border-blue-500/50 rounded-md overflow-hidden">
                                <div class="aspect-square bg-gray-950 flex items-center justify-center">
                                    @if($ehImagem)
                                        <img src="{{ $urlArquivo }}" alt="{{ $nomeArquivo }}" class="w-full h-full object-cover">
                                    @elseif($ehVideo)
                                        <video src="{{ $urlArquivo }}" class="w-full h-full object-cover" muted preload="metadata"></video>
                                    @else
                                        <div class="text-xs text-gray-500 px-3 text-center break-all">{{ strtoupper($extensao ?: 'ARQ') }}</div>
                                    @endif
                                </div>
                                <div class="text-xs text-blue-300 px-2.5 py-1.5 truncate group-hover:text-blue-200">
                                    {{ $nomeArquivo }}
                                </div>
                            </a>
                        @empty
                            <span class="text-xs text-gray-500">Sem arquivo anexado</span>
                        @endforelse
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-800">
                        <a href="{{ route('professor.posts.edit', $post) }}"
                           class="text-xs font-medium px-3 py-1.5 rounded border border-gray-700 text-gray-300 hover:bg-gray-800 transition-colors">
                            Editar
                        </a>
                        <form method="POST" action="{{ route('professor.posts.destroy', $post) }}" onsubmit="return confirm('Excluir este post?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    style="background-color: #dc2626; color: #ffffff;"
                                    onmouseover="this.style.backgroundColor='#b91c1c'"
                                    onmouseout="this.style.backgroundColor='#dc2626'"
                                    class="text-xs font-medium px-3 py-1.5 rounded transition-colors">
                                Excluir
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div>
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection
