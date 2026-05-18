@php
    /** @var \App\Models\Treino|null $treino */
    /** @var \Illuminate\Support\Collection<int, \App\Models\User> $alunos */
    $selecionados = isset($treino) ? $treino->alunos->pluck('id')->all() : [];
@endphp

<div class="p-6 space-y-5">
    {{-- Data e opcoes --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Data do treino</label>
            <input type="date" name="data" value="{{ old('data', isset($treino) ? $treino->data->format('Y-m-d') : '') }}" required
                   class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('data')<p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>@enderror
        </div>
        <label class="flex items-center gap-2.5 bg-gray-800/40 border border-gray-700 rounded-md px-3 py-2 cursor-pointer self-end">
            <input type="checkbox" name="especial" value="1" {{ old('especial', isset($treino) && $treino->especial ? 'checked' : '') }} class="rounded bg-gray-900 border-gray-700 text-blue-600 focus:ring-blue-500">
            <span class="text-sm text-gray-200">Treino especial</span>
        </label>
        <label class="flex items-center gap-2.5 bg-gray-800/40 border border-gray-700 rounded-md px-3 py-2 cursor-pointer self-end">
            <input type="checkbox" name="avisar_whatsapp" value="1" {{ old('avisar_whatsapp') ? 'checked' : '' }} class="rounded bg-gray-900 border-gray-700 text-blue-600 focus:ring-blue-500">
            <span class="text-sm text-gray-200">Avisar alunos no WhatsApp</span>
        </label>
    </div>

    {{-- Foto --}}
    <div>
        <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Foto do treino</label>
        <input type="file" name="foto" accept="image/*" {{ isset($treino) ? '' : 'required' }}
               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent file:mr-3 file:border-0 file:bg-blue-600 file:text-white file:rounded file:px-3 file:py-1 file:text-xs file:font-medium hover:file:bg-blue-700">
        @error('foto')<p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>@enderror
        @isset($treino)
            <div class="mt-3">
                <div class="text-xs text-gray-500 uppercase tracking-wider mb-1.5">Foto atual</div>
                <img src="{{ asset($treino->foto_path) }}" alt="Foto atual" class="h-32 rounded-md object-cover border border-gray-700">
            </div>
        @endisset
    </div>

    {{-- Alunos --}}
    <div>
        <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Alunos presentes</label>
        <div class="bg-gray-800/40 border border-gray-700 rounded-md p-3 max-h-80 overflow-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-2">
                @foreach($alunos as $aluno)
                    <label class="flex items-center gap-2 bg-gray-900/40 border border-gray-700 hover:border-blue-500/40 rounded-md px-2.5 py-2 cursor-pointer transition-colors">
                        <input type="checkbox" name="alunos[]" value="{{ $aluno->id }}"
                               class="rounded bg-gray-900 border-gray-700 text-blue-600 focus:ring-blue-500"
                               {{ in_array($aluno->id, old('alunos', $selecionados)) ? 'checked' : '' }}>
                        <span class="text-sm text-gray-200 truncate">{{ $aluno->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>
        @error('alunos')<p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>@enderror
    </div>
</div>

<div class="flex items-center justify-end gap-2 px-6 py-4 border-t border-gray-800">
    <a href="{{ route('professor.treinos.index') }}"
       class="text-sm font-medium px-4 py-2 rounded-md border border-gray-700 text-gray-300 hover:bg-gray-800 transition-colors">
        Cancelar
    </a>
    <button id="btnSalvarTreino" type="submit"
            style="background-color: #2563eb; color: #ffffff;"
            onmouseover="this.style.backgroundColor='#1d4ed8'"
            onmouseout="this.style.backgroundColor='#2563eb'"
            class="inline-flex items-center text-sm font-medium px-4 py-2 rounded-md transition-colors">
        <span class="btn-spin inline-block align-middle w-3.5 h-3.5 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
        <span class="btn-text">Salvar</span>
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        const btn = document.getElementById('btnSalvarTreino');
        let form  = btn;
        while (form && form.tagName !== 'FORM') { form = form.parentElement; }
        if (form && btn) {
            form.addEventListener('submit', function(){
                btn.disabled = true;
                btn.classList.add('opacity-70','cursor-not-allowed');
                const txt = btn.querySelector('.btn-text');
                const spn = btn.querySelector('.btn-spin');
                if (txt) txt.textContent = 'Salvando...';
                if (spn) spn.style.display = 'inline-block';
            }, { once: true });
        }
    });
</script>
