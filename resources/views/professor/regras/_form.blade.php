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
            <button id="btnSalvarRegra" type="submit" class="px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white">
                <span class="btn-spin inline-block align-middle w-4 h-4 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
                <span class="btn-text">{{ isset($regra) ? 'Atualizar' : 'Salvar' }}</span>
            </button>
        </div>

        <script>
        // Loading ao salvar/atualizar regra
        document.addEventListener('DOMContentLoaded', function(){
            const btn = document.getElementById('btnSalvarRegra');
            let form = btn;
            while(form && form.tagName !== 'FORM'){ form = form.parentElement; }
            if(form && btn){
                form.addEventListener('submit', function(){
                    btn.disabled = true;
                    btn.classList.add('opacity-70','cursor-not-allowed');
                    const txt = btn.querySelector('.btn-text');
                    const spn = btn.querySelector('.btn-spin');
                    if(txt) txt.textContent = '{{ isset($regra) ? 'Atualizando...' : 'Salvando...' }}';
                    if(spn) spn.style.display = 'inline-block';
                }, { once: true });
            }
        });
        </script>
    </div>
</div>
