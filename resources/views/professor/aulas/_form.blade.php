@php /** @var \App\Models\AulaSequencia|null $sequencia */ @endphp

<div class="p-6 space-y-5">
    <div>
        <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Número da aula</label>
        <input type="number" min="1" name="numero" value="{{ old('numero', isset($sequencia) ? $sequencia->numero : '') }}" required
               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        @error('numero')<p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Descrição da sequência</label>
        <textarea name="descricao" rows="4" required
                  class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none">{{ old('descricao', isset($sequencia) ? $sequencia->descricao : '') }}</textarea>
        @error('descricao')<p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Imagem da sequência <span class="text-gray-500 normal-case font-normal">(opcional)</span></label>
        <input type="file" name="imagem" accept="image/*"
               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent file:mr-3 file:border-0 file:bg-blue-600 file:text-white file:rounded file:px-3 file:py-1 file:text-xs file:font-medium hover:file:bg-blue-700">
        @error('imagem')<p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>@enderror
        @isset($sequencia)
            @if($sequencia->video_path)
                <div class="mt-3">
                    <div class="text-xs text-gray-500 uppercase tracking-wider mb-1.5">Imagem atual</div>
                    <img src="{{ asset($sequencia->video_path) }}" alt="Imagem" class="h-24 rounded-md object-cover border border-gray-700">
                </div>
            @endif
        @endisset
    </div>

    <label class="flex items-center gap-2.5 bg-gray-800/40 border border-gray-700 rounded-md px-3 py-2 cursor-pointer w-fit">
        <input type="checkbox" name="ativo" value="1" {{ old('ativo', isset($sequencia) ? ($sequencia->ativo ? 'checked' : '') : 'checked') }} class="rounded bg-gray-900 border-gray-700 text-blue-600 focus:ring-blue-500">
        <span class="text-sm text-gray-200">Ativo</span>
    </label>
</div>

<div class="flex items-center justify-end gap-2 px-6 py-4 border-t border-gray-800">
    <a href="{{ route('professor.aulas-sequencia.index') }}"
       class="text-sm font-medium px-4 py-2 rounded-md border border-gray-700 text-gray-300 hover:bg-gray-800 transition-colors">
        Cancelar
    </a>
    <button id="btnSalvarSequencia" type="submit"
            style="background-color: #2563eb; color: #ffffff;"
            onmouseover="this.style.backgroundColor='#1d4ed8'"
            onmouseout="this.style.backgroundColor='#2563eb'"
            class="inline-flex items-center text-sm font-medium px-4 py-2 rounded-md transition-colors">
        <span class="btn-spin inline-block align-middle w-3.5 h-3.5 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
        <span class="btn-text">{{ isset($sequencia) ? 'Atualizar' : 'Salvar' }}</span>
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        const btn = document.getElementById('btnSalvarSequencia');
        let form  = btn;
        while (form && form.tagName !== 'FORM') { form = form.parentElement; }
        if (form && btn) {
            form.addEventListener('submit', function(){
                btn.disabled = true;
                btn.classList.add('opacity-70','cursor-not-allowed');
                const txt = btn.querySelector('.btn-text');
                const spn = btn.querySelector('.btn-spin');
                if (txt) txt.textContent = '{{ isset($sequencia) ? 'Atualizando...' : 'Salvando...' }}';
                if (spn) spn.style.display = 'inline-block';
            }, { once: true });
        }
    });
</script>
