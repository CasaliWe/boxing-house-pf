@php
    /** @var \App\Models\Treino|null $treino */
    /** @var \Illuminate\Support\Collection<int, \App\Models\User> $alunos */
    $selecionados = isset($treino) ? $treino->alunos->pluck('id')->all() : [];
@endphp

<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-300 mb-2">Data do treino</label>
            <input type="date" name="data" value="{{ old('data', isset($treino) ? $treino->data->format('Y-m-d') : '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('data')<p class="text-red-400 text-sm mt-2">{{ $message }}</p>@enderror
        </div>
        <div class="flex items-center gap-3">
            <input type="checkbox" name="especial" value="1" {{ old('especial', isset($treino) && $treino->especial ? 'checked' : '') }} class="rounded bg-gray-800 border-gray-600 text-blue-500 focus:ring-blue-500">
            <label class="text-sm text-gray-300">Treino especial</label>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-300 mb-2">Foto do treino</label>
        <input type="file" name="foto" accept="image/*" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" {{ isset($treino) ? '' : 'required' }}>
        @error('foto')<p class="text-red-400 text-sm mt-2">{{ $message }}</p>@enderror
        @isset($treino)
            <div class="mt-3">
                <img src="{{ asset('storage/'.$treino->foto_path) }}" alt="Foto atual" class="h-28 rounded object-cover border border-gray-600">
            </div>
        @endisset
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-300 mb-2">Alunos presentes</label>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-2 max-h-80 overflow-auto border border-gray-600 rounded-lg p-3 bg-gray-800/40">
            @foreach($alunos as $aluno)
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="alunos[]" value="{{ $aluno->id }}" class="rounded bg-gray-800 border-gray-600 text-blue-500 focus:ring-blue-500"
                           {{ in_array($aluno->id, old('alunos', $selecionados)) ? 'checked' : '' }}>
                    <span class="text-sm text-gray-200">{{ $aluno->name }} <span class="text-gray-500">({{ $aluno->email }})</span></span>
                </label>
            @endforeach
        </div>
        @error('alunos')<p class="text-red-400 text-sm mt-2">{{ $message }}</p>@enderror
    </div>

    <div class="flex items-center gap-3">
        <a href="{{ route('professor.treinos.index') }}" class="px-4 py-2 rounded-md border border-gray-600 text-gray-200 hover:bg-gray-700">Cancelar</a>
        <button class="px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white">Salvar</button>
    </div>
</div>
