@extends('layouts.app')

@section('title', 'Avaliações - Professor')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold text-blue-400">⭐ Gerenciar Avaliações</h1>
        <p class="text-gray-400">Aprove ou reprove as avaliações dos alunos que aparecerão na landing page.</p>
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        @if($avaliacoes->count() > 0)
            <div class="space-y-6">
                @foreach($avaliacoes as $avaliacao)
                    <div class="bg-gray-800 border border-gray-700 rounded-lg p-6">
                        <!-- Header com informações do aluno -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-4">
                                @if($avaliacao->foto_avaliacao)
                                    <img src="{{ asset('storage/' . $avaliacao->foto_avaliacao) }}" 
                                         alt="Foto de {{ $avaliacao->user->name }}" 
                                         class="w-16 h-16 rounded-full object-cover border-2 border-blue-400">
                                @else
                                    <div class="w-16 h-16 rounded-full bg-gradient-blue flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <h3 class="text-xl font-semibold text-white">{{ $avaliacao->user->name }}</h3>
                                    <p class="text-gray-400 text-sm">{{ $avaliacao->user->email }}</p>
                                    <p class="text-gray-400 text-sm">
                                        Enviado em {{ $avaliacao->created_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Comentário -->
                        <div class="mb-6">
                            <h4 class="text-lg font-medium text-blue-400 mb-2">Comentário:</h4>
                            <div class="bg-gray-900 rounded-lg p-4 border-l-4 border-blue-600">
                                <p class="text-gray-300 italic">"{{ $avaliacao->comentario }}"</p>
                            </div>
                        </div>

                        <!-- Configurações -->
                        <div class="mb-6">
                            <h4 class="text-lg font-medium text-blue-400 mb-2">Configurações:</h4>
                            <div class="flex items-center gap-6 text-sm">
                                <div class="flex items-center gap-2">
                                    @if($avaliacao->exibir_landing)
                                        <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-green-400">Autorizado para landing page</span>
                                    @else
                                        <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        <span class="text-red-400">Não autorizado para landing page</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Ações -->
                        <div class="flex flex-wrap gap-3">
                            @if(!$avaliacao->ativo)
                                <form method="POST" action="{{ route('professor.avaliacoes.aprovar', $avaliacao) }}" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Aprovar
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('professor.avaliacoes.reprovar', $avaliacao) }}" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Reprovar
                                    </button>
                                </form>
                            @endif
                            
                            <form method="POST" action="{{ route('professor.avaliacoes.destroy', $avaliacao) }}" class="inline"
                                  onsubmit="return confirm('Tem certeza que deseja excluir esta avaliação? Esta ação não pode ser desfeita.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Excluir
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginação -->
            @if($avaliacoes->hasPages())
                <div class="mt-8">
                    {{ $avaliacoes->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-300 mb-2">Nenhuma avaliação encontrada</h3>
                <p class="text-gray-400">Os alunos ainda não enviaram avaliações ou não há avaliações pendentes.</p>
            </div>
        @endif
    </div>
</div>
@endsection