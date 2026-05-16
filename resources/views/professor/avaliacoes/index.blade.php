@extends('layouts.app')

@section('title', 'Avaliações - Professor')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- Cabeçalho --}}
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Gerenciar avaliações</h1>
            <p class="text-sm text-gray-400 mt-1">Aprove ou reprove avaliações para a landing page</p>
        </div>
    </div>

    {{-- Lista de avaliações --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
            <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.6.9-1 1.651-1.155.751-.154 1.532.055 2.152.625L19.64 6.55a2 2 0 01.25 2.83l-7.18 8.61c-.34.407-.808.695-1.335.82L9 19.5l.694-2.375c.125-.527.413-.995.82-1.335l8.61-7.18a2 2 0 002.83.25z" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-white">Avaliações recebidas</h3>
                <p class="text-xs text-gray-400">Comentários dos alunos sobre a academia</p>
            </div>
        </div>

        <div class="p-6">
            @if($avaliacoes->count() > 0)
                <div class="space-y-3">
                    @foreach($avaliacoes as $avaliacao)
                        <div class="bg-gray-800/40 border border-gray-700 rounded-lg p-5">
                            {{-- Topo: foto + nome + status --}}
                            <div class="flex items-start justify-between gap-3 mb-4 flex-wrap">
                                <div class="flex items-center gap-3 min-w-0">
                                    @if($avaliacao->foto_avaliacao)
                                        <img src="{{ asset($avaliacao->foto_avaliacao) }}" alt="Foto"
                                             class="w-12 h-12 rounded-full object-cover border-2 border-blue-500/40 shrink-0">
                                    @else
                                        <div class="w-12 h-12 rounded-full bg-linear-to-br from-blue-600 to-blue-800 flex items-center justify-center text-white text-base font-semibold shrink-0">
                                            {{ mb_strtoupper(mb_substr($avaliacao->nome_exibicao ?: '?', 0, 1)) }}
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <div class="text-base font-semibold text-white truncate">{{ $avaliacao->nome_exibicao }}</div>
                                        <div class="text-xs text-gray-500 truncate">
                                            {{ $avaliacao->user ? $avaliacao->user->email : 'Avaliação pública' }}
                                            · {{ $avaliacao->created_at->format('d/m/Y H:i') }}
                                        </div>
                                    </div>
                                </div>
                                <span class="text-xs font-semibold px-2 py-1 rounded {{ $avaliacao->ativo ? 'bg-green-500/20 text-green-300' : 'bg-yellow-500/20 text-yellow-300' }}">
                                    {{ $avaliacao->ativo ? 'Aprovada' : 'Pendente' }}
                                </span>
                            </div>

                            {{-- Comentário --}}
                            <div class="bg-gray-900/60 border-l-4 border-blue-500/60 rounded-md p-3 mb-3">
                                <p class="text-sm text-gray-200 italic">"{{ $avaliacao->comentario }}"</p>
                            </div>

                            {{-- Config + ações --}}
                            <div class="flex items-center justify-between flex-wrap gap-3">
                                <div class="flex items-center gap-2 text-xs">
                                    @if($avaliacao->exibir_landing)
                                        <span class="inline-flex items-center gap-1 text-green-400">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            Autorizada para landing
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-red-400">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            Não autorizada
                                        </span>
                                    @endif
                                </div>

                                <div class="flex items-center gap-2">
                                    @if(!$avaliacao->ativo)
                                        <form method="POST" action="{{ route('professor.avaliacoes.aprovar', $avaliacao) }}" class="inline">
                                            @csrf
                                            <button type="submit"
                                                    style="background-color: #16a34a; color: #ffffff;"
                                                    onmouseover="this.style.backgroundColor='#15803d'"
                                                    onmouseout="this.style.backgroundColor='#16a34a'"
                                                    class="text-xs font-medium px-3 py-1.5 rounded-md transition-colors">
                                                Aprovar
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('professor.avaliacoes.reprovar', $avaliacao) }}" class="inline">
                                            @csrf
                                            <button type="submit"
                                                    style="background-color: #ca8a04; color: #ffffff;"
                                                    onmouseover="this.style.backgroundColor='#a16207'"
                                                    onmouseout="this.style.backgroundColor='#ca8a04'"
                                                    class="text-xs font-medium px-3 py-1.5 rounded-md transition-colors">
                                                Reprovar
                                            </button>
                                        </form>
                                    @endif

                                    <form method="POST" action="{{ route('professor.avaliacoes.destroy', $avaliacao) }}" class="inline"
                                          onsubmit="return confirm('Tem certeza que deseja excluir esta avaliação?')">
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

                @if($avaliacoes->hasPages())
                    <div class="mt-6">{{ $avaliacoes->links() }}</div>
                @endif
            @else
                <div class="text-center py-12 text-sm text-gray-500">
                    Os alunos ainda não enviaram avaliações.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
