@php
    // Tipo atualmente selecionado (pacote ou experimental)
    $tipoAtual = old('tipo', $valor->tipo ?? \App\Models\ValorPlano::TIPO_PACOTE);
@endphp

<div class="p-6 space-y-5">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label for="tipo" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Tipo</label>
            <select id="tipo" name="tipo"
                    class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="pacote" {{ $tipoAtual === 'pacote' ? 'selected' : '' }}>Pacote por aulas</option>
                <option value="experimental" {{ $tipoAtual === 'experimental' ? 'selected' : '' }}>Aula experimental</option>
            </select>
            @error('tipo')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
        </div>

        <div id="campoAulasMes">
            <label for="aulas_mes" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Até quantas aulas no mês</label>
            <input type="number" id="aulas_mes" name="aulas_mes" min="1" max="100" value="{{ old('aulas_mes', $valor->aulas_mes ?? '') }}" placeholder="Ex.: 8"
                   class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('aulas_mes')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
        </div>

        <div>
            <label for="valor_aula" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Valor por aula (R$)</label>
            <input type="number" step="0.01" id="valor_aula" name="valor_aula" value="{{ old('valor_aula', isset($valor) ? number_format((float) $valor->valor_aula, 2, '.', '') : '') }}" placeholder="Ex.: 35.00"
                   class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('valor_aula')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
        </div>
    </div>

    {{-- Pré-visualização em tempo real --}}
    <div class="bg-blue-500/5 border border-blue-500/30 rounded-md px-4 py-3 text-sm">
        <span class="text-xs text-blue-300 uppercase tracking-wider font-semibold">Prévia</span>
        <div id="previaValor" class="text-gray-200 mt-1"></div>
    </div>
</div>

<div class="flex items-center justify-end gap-2 px-6 py-4 border-t border-gray-800">
    <a href="{{ route('professor.valores.index') }}"
       class="text-sm font-medium px-4 py-2 rounded-md border border-gray-700 text-gray-300 hover:bg-gray-800 transition-colors">
        Cancelar
    </a>
    <button id="btnSalvarValor" type="submit"
            style="background-color: #2563eb; color: #ffffff;"
            onmouseover="this.style.backgroundColor='#1d4ed8'"
            onmouseout="this.style.backgroundColor='#2563eb'"
            class="inline-flex items-center text-sm font-medium px-4 py-2 rounded-md transition-colors">
        <span class="btn-spin inline-block align-middle w-3.5 h-3.5 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
        <span class="btn-text">{{ isset($valor) ? 'Atualizar' : 'Salvar' }}</span>
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        const tipo       = document.getElementById('tipo');
        const campoAulas = document.getElementById('campoAulasMes');
        const aulas      = document.getElementById('aulas_mes');
        const valorAula  = document.getElementById('valor_aula');
        const previa     = document.getElementById('previaValor');
        const moeda      = (v) => Number(v || 0).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

        // Atualiza a prévia com base no tipo / valores digitados
        function atualizarPrevia() {
            const experimental = tipo.value === 'experimental';
            campoAulas.classList.toggle('hidden', experimental);

            if (experimental) {
                previa.textContent = `Aula experimental: ${moeda(valorAula.value)}`;
                return;
            }
            const quantidade = parseInt(aulas.value || '0', 10);
            const total      = quantidade * Number(valorAula.value || 0);
            previa.textContent = `Até ${quantidade || 0} aulas/mês · ${moeda(valorAula.value)} por aula · Total até ${moeda(total)}`;
        }

        tipo?.addEventListener('change', atualizarPrevia);
        aulas?.addEventListener('input', atualizarPrevia);
        valorAula?.addEventListener('input', atualizarPrevia);
        atualizarPrevia();

        // Loading no botão de salvar
        const btn = document.getElementById('btnSalvarValor');
        let form  = btn;
        while (form && form.tagName !== 'FORM') { form = form.parentElement; }
        if (form && btn) {
            form.addEventListener('submit', function(){
                btn.disabled = true;
                btn.classList.add('opacity-70','cursor-not-allowed');
                const txt = btn.querySelector('.btn-text');
                const spn = btn.querySelector('.btn-spin');
                if (txt) txt.textContent = '{{ isset($valor) ? "Atualizando..." : "Salvando..." }}';
                if (spn) spn.style.display = 'inline-block';
            }, { once: true });
        }
    });
</script>
