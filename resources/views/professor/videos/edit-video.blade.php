@extends('layouts.app')

@section('title', 'Editar Vídeo - ' . $video->titulo)

@section('content')
<div class="space-y-8">
    <!-- Header melhorado -->
    <div class="space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <a href="{{ route('professor.videos.show', $modulo) }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Voltar
            </a>
        </div>
        
        <div class="bg-gradient-card border border-gray-600 rounded-xl p-4 sm:p-6">
            <div class="space-y-4">
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white">Editar Vídeo</h1>
                <p class="text-gray-300 text-sm sm:text-base">Edite as informações do vídeo "{{ $video->titulo }}" do módulo "{{ $modulo->titulo }}".</p>
            </div>
        </div>
    </div>
    
    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        <form method="POST" action="{{ route('professor.videos.update-video', [$modulo, $video]) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="titulo" class="block text-sm font-medium text-gray-300 mb-2">Título do Vídeo</label>
                    <input type="text" id="titulo" name="titulo" value="{{ old('titulo', $video->titulo) }}" 
                           class="w-full px-4 py-3 rounded-lg bg-gray-800 border border-gray-600 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('titulo') border-red-500 @enderror"
                           placeholder="Ex: Como executar o jab perfeito" required>
                    @error('titulo')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="arquivo" class="block text-sm font-medium text-gray-300 mb-2">
                        Arquivo de Vídeo 
                        <span class="text-gray-400 font-normal">(deixe em branco para manter o atual)</span>
                    </label>
                    
                    <!-- Preview do vídeo atual -->
                    <div class="mb-4">
                        <div class="aspect-[9/16] w-48 overflow-hidden rounded bg-gray-700 mb-2">
                            <video class="w-full h-full object-cover" controls preload="metadata">
                                <source src="{{ asset('storage/'.$video->arquivo_path) }}" type="video/mp4">
                                Seu navegador não suporta vídeo.
                            </video>
                        </div>
                        <p class="text-gray-400 text-sm">Vídeo atual: {{ $video->duracao_formatada }}</p>
                    </div>
                    
                    <div class="relative">
                        <input type="file" id="arquivo" name="arquivo" accept="video/*"
                               class="w-full px-4 py-3 rounded-lg bg-gray-800 border border-gray-600 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('arquivo') border-red-500 @enderror file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                        <p class="text-gray-400 text-xs mt-1">
                            Formatos aceitos: MP4, AVI, MOV, WebM. Tamanho máximo: 100MB.<br>
                            Recomendado: Vídeos verticais (1080x1920) de até 5 minutos.
                        </p>
                    </div>
                    @error('arquivo')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="ordem" class="block text-sm font-medium text-gray-300 mb-2">Ordem de Exibição</label>
                    <input type="number" id="ordem" name="ordem" value="{{ old('ordem', $video->ordem) }}" min="0"
                           class="w-full px-4 py-3 rounded-lg bg-gray-800 border border-gray-600 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('ordem') border-red-500 @enderror"
                           placeholder="0">
                    <p class="text-gray-400 text-xs mt-1">Número menor aparece primeiro</p>
                    @error('ordem')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="descricao" class="block text-sm font-medium text-gray-300 mb-2">Descrição (opcional)</label>
                    <textarea id="descricao" name="descricao" rows="3"
                              class="w-full px-4 py-3 rounded-lg bg-gray-800 border border-gray-600 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('descricao') border-red-500 @enderror"
                              placeholder="Descreva o conteúdo deste vídeo...">{{ old('descricao', $video->descricao) }}</textarea>
                    @error('descricao')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <div class="flex items-center">
                        <input type="checkbox" id="ativo" name="ativo" value="1" {{ old('ativo', $video->ativo) ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 bg-gray-800 border-gray-600 rounded focus:ring-blue-500">
                        <label for="ativo" class="ml-2 text-sm text-gray-300">Vídeo ativo (visível para alunos)</label>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-end">
                <a href="{{ route('professor.videos.show', $modulo) }}" class="px-6 py-3 rounded-lg border border-gray-600 text-gray-300 hover:bg-gray-700 transition duration-150 text-center">Cancelar</a>
                <button type="submit" class="px-6 py-3 rounded-lg bg-gradient-blue text-white hover:opacity-95 transition duration-150 focus:outline-none focus:ring-2 focus:ring-blue-500">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>
@endsection