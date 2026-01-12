<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2">
            <label for="titulo" class="block text-sm font-medium text-gray-300 mb-2">Título</label>
            <input type="text" id="titulo" name="titulo" value="{{ old('titulo', $regra->titulo ?? '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ex.: Conduta e Permanência">
            @error('titulo')
                <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="ordem" class="block text-sm font-medium text-gray-300 mb-2">Ordem (opcional)</label>
            <input type="number" id="ordem" name="ordem" value="{{ old('ordem', $regra->ordem ?? '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="0">
            @error('ordem')
                <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div>
        <label for="conteudo" class="block text-sm font-medium text-gray-300 mb-2">Conteúdo</label>
        <textarea id="conteudo" name="conteudo" rows="6" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Descreva a regra/termo em linguagem clara e objetiva.">{{ old('conteudo', $regra->conteudo ?? '') }}</textarea>
        @error('conteudo')
            <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
        @enderror
    </div>

    <div class="flex items-center justify-between">
        <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="ativo" value="1" {{ old('ativo', $regra->ativo ?? true) ? 'checked' : '' }} class="rounded bg-gray-800 border-gray-600 text-blue-500 focus:ring-blue-500">
            <span class="text-gray-300">Ativo</span>
        </label>

        <div class="flex items-center gap-3">
            <a href="{{ route('professor.regras.index') }}" class="px-4 py-2 rounded-md border border-gray-600 text-gray-200 hover:bg-gray-700">Cancelar</a>
            <button type="submit" class="px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white">Salvar</button>
        </div>
    </div>
</div>
