@php /** @var \App\Models\AulaSequencia|null $sequencia */ @endphp
<div class="space-y-6">
    <div class="grid grid-cols-1 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Número da aula</label>
            <input type="number" min="1" name="numero" value="{{ old('numero', isset($sequencia) ? $sequencia->numero : '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('numero')<p class="text-red-400 text-sm mt-2">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Descrição da sequência</label>
            <textarea name="descricao" rows="4" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('descricao', isset($sequencia) ? $sequencia->descricao : '') }}</textarea>
            @error('descricao')<p class="text-red-400 text-sm mt-2">{{ $message }}</p>@enderror
        </div>
        <div class="flex items-center gap-3">
            <input type="checkbox" name="ativo" value="1" {{ old('ativo', isset($sequencia) ? ($sequencia->ativo ? 'checked' : '') : 'checked') }} class="rounded bg-gray-800 border-gray-600 text-blue-500 focus:ring-blue-500">
            <label class="text-sm text-gray-300">Ativo</label>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <a href="{{ route('professor.aulas-sequencia.index') }}" class="px-4 py-2 rounded-md border border-gray-600 text-gray-200 hover:bg-gray-700">Cancelar</a>
        <button type="submit" class="px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white">{{ isset($sequencia) ? 'Atualizar' : 'Salvar' }}</button>
    </div>
</div>
