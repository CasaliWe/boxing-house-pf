<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="vezes_semana" class="block text-sm font-medium text-gray-300 mb-2">Vezes por semana</label>
            <input type="number" id="vezes_semana" name="vezes_semana" min="1" max="5" value="{{ old('vezes_semana', $valor->vezes_semana ?? '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ex.: 2">
            @error('vezes_semana')
                <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="valor" class="block text-sm font-medium text-gray-300 mb-2">Valor (R$)</label>
            <input type="number" step="0.01" id="valor" name="valor" value="{{ old('valor', isset($valor) ? number_format($valor->valor, 2, '.', '') : '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ex.: 130.00">
            @error('valor')
                <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('professor.valores.index') }}" class="px-4 py-2 rounded-md border border-gray-600 text-gray-200 hover:bg-gray-700">Cancelar</a>
        <button id="btnSalvarValor" type="submit" class="px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white">
            <span class="btn-spin inline-block align-middle w-4 h-4 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
            <span class="btn-text">{{ isset($valor) ? 'Atualizar' : 'Salvar' }}</span>
        </button>
    </div>

    <script>
    // Loading ao salvar/atualizar valor
    document.addEventListener('DOMContentLoaded', function(){
        const btn = document.getElementById('btnSalvarValor');
        let form = btn;
        while(form && form.tagName !== 'FORM'){ form = form.parentElement; }
        if(form && btn){
            form.addEventListener('submit', function(){
                btn.disabled = true;
                btn.classList.add('opacity-70','cursor-not-allowed');
                const txt = btn.querySelector('.btn-text');
                const spn = btn.querySelector('.btn-spin');
                if(txt) txt.textContent = '{{ isset($valor) ? "Atualizando..." : "Salvando..." }}';
                if(spn) spn.style.display = 'inline-block';
            }, { once: true });
        }
    });
    </script>
</div>
