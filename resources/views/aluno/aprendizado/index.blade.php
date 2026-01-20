@extends('layouts.app')

@section('title', 'Aprendizado EAD')

@section('content')
<div class="space-y-8">
    <div class="text-center">
        <h1 class="text-2xl md:text-3xl font-bold text-blue-400 mb-2">📚 Aprendizado EAD</h1>
        <p class="text-gray-400 text-sm md:text-base">Você tem {{ $numeroAulasAluno }} aula{{ $numeroAulasAluno != 1 ? 's' : '' }} registrada{{ $numeroAulasAluno != 1 ? 's' : '' }}.</p>
    </div>

    @if($modulosDisponiveis->count() > 0)
        <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
            <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-2">
                <span class="text-green-400">✓</span>
                Módulos Disponíveis
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($modulosDisponiveis as $modulo)
                    <div class="border border-gray-600 rounded-lg p-4 md:p-5 bg-gray-800/40 hover:bg-gray-800/60 transition-colors group">
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-white font-semibold text-lg md:text-xl mb-2 group-hover:text-blue-300 transition-colors">{{ $modulo->titulo }}</h3>
                                
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="bg-blue-600/20 text-blue-300 px-2 py-1 rounded text-xs font-medium">
                                        {{ ucfirst($modulo->tema) }}
                                    </span>
                                    <span class="text-green-400 text-xs flex items-center gap-1">
                                        <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                                        Liberado
                                    </span>
                                </div>
                                
                                @if($modulo->descricao)
                                    <p class="text-gray-300 text-sm leading-relaxed mb-3 line-clamp-3">{{ $modulo->descricao }}</p>
                                @endif
                            </div>
                            
                            <div class="flex items-center justify-between text-sm text-gray-400 py-2 border-t border-gray-700">
                                <span>{{ $modulo->videos_count }} vídeo{{ $modulo->videos_count != 1 ? 's' : '' }}</span>
                                <span class="text-xs bg-gray-700 px-2 py-1 rounded">A partir da aula {{ $modulo->aula_minima_acesso }}</span>
                            </div>
                            
                            <a href="{{ route('aluno.aprendizado.show', $modulo) }}" class="block w-full py-3 px-4 rounded-lg bg-gradient-blue text-white text-center font-medium transition duration-150 hover:opacity-95 active:scale-95 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Assistir Vídeos
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if($proximosModulos->count() > 0)
        <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
            <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-2">
                <span class="text-yellow-400">🔒</span>
                Próximos Módulos
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($proximosModulos as $modulo)
                    <div class="border border-gray-600 rounded-lg p-4 md:p-5 bg-gray-800/20 opacity-75">
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-gray-300 font-semibold text-lg md:text-xl mb-2">{{ $modulo->titulo }}</h3>
                                
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="bg-gray-600/20 text-gray-400 px-2 py-1 rounded text-xs font-medium">
                                        {{ ucfirst($modulo->tema) }}
                                    </span>
                                    <span class="text-yellow-400 text-xs flex items-center gap-1">
                                        <span class="w-2 h-2 bg-yellow-400 rounded-full"></span>
                                        Bloqueado
                                    </span>
                                </div>
                                
                                @if($modulo->descricao)
                                    <p class="text-gray-400 text-sm leading-relaxed mb-3 line-clamp-3">{{ $modulo->descricao }}</p>
                                @endif
                            </div>
                            
                            <div class="flex items-center justify-between text-sm text-gray-500 py-2 border-t border-gray-700">
                                <span>{{ $modulo->videos_count }} vídeo{{ $modulo->videos_count != 1 ? 's' : '' }}</span>
                                <span class="text-xs bg-yellow-600/20 text-yellow-400 px-2 py-1 rounded">Aula {{ $modulo->aula_minima_acesso }} necessária</span>
                            </div>
                            
                            <div class="w-full py-3 px-4 rounded-lg bg-gray-700 text-gray-400 text-center font-medium flex items-center justify-center cursor-not-allowed">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                                Bloqueado
                            </div>
                            
                            <p class="text-gray-500 text-xs text-center leading-relaxed">
                                Você precisa completar <strong>{{ $modulo->aula_minima_acesso }}</strong> aula{{ $modulo->aula_minima_acesso != 1 ? 's' : '' }} para desbloquear este conteúdo
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if($modulosDisponiveis->count() == 0 && $proximosModulos->count() == 0)
        <div class="bg-gradient-card border border-gray-600 rounded-xl p-12 text-center">
            <div class="text-6xl mb-4">📚</div>
            <h2 class="text-2xl font-semibold text-white mb-2">Nenhum conteúdo disponível</h2>
            <p class="text-gray-400">Os módulos de aprendizado ainda não foram criados ou você precisa de mais aulas para acessá-los.</p>
        </div>
    @endif

    <!-- Informações sobre progresso -->
    @if($proximosModulos->count() > 0)
        <div class="bg-blue-900/20 border border-blue-600 rounded-xl p-6">
            <div class="flex items-start gap-4">
                <div class="text-blue-400 text-2xl">💡</div>
                <div class="text-blue-100">
                    <h3 class="font-semibold mb-2">Continue treinando!</h3>
                    <p class="text-sm text-blue-200/90">
                        Você tem {{ $numeroAulasAluno }} aula{{ $numeroAulasAluno != 1 ? 's' : '' }} registrada{{ $numeroAulasAluno != 1 ? 's' : '' }}. 
                        Continue participando dos treinos para desbloquear mais conteúdos educativos.
                        O próximo módulo será liberado na aula {{ $proximosModulos->first()->aula_minima_acesso }}.
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection