@php
    /** @var \App\Models\Post $post */
    $tipos = \App\Models\Post::TIPOS;
    $dataPostagem = old('data_postagem', $post->data_postagem ? $post->data_postagem->format('Y-m-d\TH:i') : '');
@endphp

<div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
    <div class="p-6 space-y-5">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Titulo</label>
                <input type="text" name="titulo" value="{{ old('titulo', $post->titulo) }}" required maxlength="255"
                       class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('titulo')<p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Data e horario</label>
                <input type="datetime-local" name="data_postagem" value="{{ $dataPostagem }}" required
                       class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('data_postagem')<p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Tipo</label>
            <div class="grid grid-cols-3 gap-2">
                @foreach($tipos as $valor => $label)
                    <label class="flex items-center justify-center gap-2 bg-gray-800/50 border border-gray-700 rounded-md px-3 py-2 cursor-pointer hover:border-blue-500/50">
                        <input type="radio" name="tipo" value="{{ $valor }}" required
                               class="bg-gray-900 border-gray-700 text-blue-600 focus:ring-blue-500"
                               {{ old('tipo', $post->tipo) === $valor ? 'checked' : '' }}>
                        <span class="text-sm text-gray-200">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
            @error('tipo')<p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Arquivos</label>
            <input type="file" name="arquivos[]" multiple
                   class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent file:mr-3 file:border-0 file:bg-blue-600 file:text-white file:rounded file:px-3 file:py-1 file:text-xs file:font-medium hover:file:bg-blue-700">
            @error('arquivos')<p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>@enderror
            @error('arquivos.*')<p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>@enderror

            @if(!empty($post->arquivos))
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach($post->arquivos as $arquivo)
                        <a href="{{ asset($arquivo['caminho']) }}" target="_blank"
                           class="inline-flex items-center gap-2 text-xs text-blue-300 bg-blue-500/10 border border-blue-500/20 rounded-md px-2.5 py-1.5">
                            {{ $arquivo['nome'] ?? basename($arquivo['caminho']) }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <div>
            <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Legenda</label>
            <textarea name="legenda" rows="8"
                      class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-y">{{ old('legenda', $post->legenda) }}</textarea>
            @error('legenda')<p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-2 px-6 py-4 border-t border-gray-800">
        <a href="{{ route('professor.posts.index') }}"
           class="text-center text-sm font-medium px-4 py-2 rounded-md border border-gray-700 text-gray-300 hover:bg-gray-800 transition-colors">
            Cancelar
        </a>
        <button type="submit"
                style="background-color: #2563eb; color: #ffffff;"
                onmouseover="this.style.backgroundColor='#1d4ed8'"
                onmouseout="this.style.backgroundColor='#2563eb'"
                class="text-sm font-medium px-4 py-2 rounded-md transition-colors">
            Salvar
        </button>
    </div>
</div>
