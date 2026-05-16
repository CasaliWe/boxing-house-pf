<div class="p-6 space-y-5">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="md:col-span-2">
            <label for="titulo" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Título</label>
            <input type="text" id="titulo" name="titulo" value="{{ old('titulo', $regra->titulo ?? '') }}" placeholder="Ex.: Conduta e permanência"
                   class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('titulo')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="ordem" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Ordem <span class="text-gray-500 normal-case font-normal">(opcional)</span></label>
            <input type="number" id="ordem" name="ordem" value="{{ old('ordem', $regra->ordem ?? '') }}" placeholder="0"
                   class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('ordem')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
        </div>
    </div>

    <div>
        <label for="conteudo" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Conteúdo</label>
        <textarea id="conteudo" name="conteudo" rows="6" placeholder="Descreva a regra/termo em linguagem clara e objetiva."
                  class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none">{{ old('conteudo', $regra->conteudo ?? '') }}</textarea>
        @error('conteudo')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
    </div>

    <label class="flex items-center gap-2.5 bg-gray-800/40 border border-gray-700 rounded-md px-3 py-2 cursor-pointer w-fit">
        <input type="checkbox" name="ativo" value="1" {{ old('ativo', $regra->ativo ?? true) ? 'checked' : '' }} class="rounded bg-gray-900 border-gray-700 text-blue-600 focus:ring-blue-500">
        <span class="text-sm text-gray-200">Ativo</span>
    </label>
</div>

<div class="flex items-center justify-end gap-2 px-6 py-4 border-t border-gray-800">
    <a href="{{ route('professor.regras.index') }}"
       class="text-sm font-medium px-4 py-2 rounded-md border border-gray-700 text-gray-300 hover:bg-gray-800 transition-colors">
        Cancelar
    </a>
    <button id="btnSalvarRegra" type="submit"
            style="background-color: #2563eb; color: #ffffff;"
            onmouseover="this.style.backgroundColor='#1d4ed8'"
            onmouseout="this.style.backgroundColor='#2563eb'"
            class="inline-flex items-center text-sm font-medium px-4 py-2 rounded-md transition-colors">
        <span class="btn-spin inline-block align-middle w-3.5 h-3.5 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
        <span class="btn-text">{{ isset($regra) ? 'Atualizar' : 'Salvar' }}</span>
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        const btn = document.getElementById('btnSalvarRegra');
        let form  = btn;
        while (form && form.tagName !== 'FORM') { form = form.parentElement; }
        if (form && btn) {
            form.addEventListener('submit', function(){
                btn.disabled = true;
                btn.classList.add('opacity-70','cursor-not-allowed');
                const txt = btn.querySelector('.btn-text');
                const spn = btn.querySelector('.btn-spin');
                if (txt) txt.textContent = '{{ isset($regra) ? 'Atualizando...' : 'Salvando...' }}';
                if (spn) spn.style.display = 'inline-block';
            }, { once: true });
        }
    });
</script>
