@php
    /** @var \App\Models\Movimentacao|null $movimentacao */
    $tipoAtual   = old('tipo',   $movimentacao->tipo   ?? ($tipo ?? \App\Models\Movimentacao::TIPO_ENTRADA));
    $statusAtual = old('status', $movimentacao->status ?? \App\Models\Movimentacao::STATUS_ABERTO);
    $userIdAtual = old('user_id', $movimentacao->user_id ?? null);
@endphp

<div class="p-6 space-y-5">
    {{-- Tipo (entrada / saída) --}}
    <div>
        <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Tipo</label>
        <div class="grid grid-cols-2 gap-2">
            <label class="flex items-center justify-center gap-2 bg-gray-800 border border-gray-700 hover:border-green-500/60 rounded-md px-3 py-2.5 cursor-pointer transition-colors has-checked:border-green-500/80 has-checked:bg-green-500/10">
                <input type="radio" name="tipo" value="entrada" id="tipo-entrada" {{ $tipoAtual === 'entrada' ? 'checked' : '' }} class="text-green-600 focus:ring-green-500">
                <span class="text-sm font-medium text-green-300">Entrada</span>
            </label>
            <label class="flex items-center justify-center gap-2 bg-gray-800 border border-gray-700 hover:border-red-500/60 rounded-md px-3 py-2.5 cursor-pointer transition-colors has-checked:border-red-500/80 has-checked:bg-red-500/10">
                <input type="radio" name="tipo" value="saida" id="tipo-saida" {{ $tipoAtual === 'saida' ? 'checked' : '' }} class="text-red-600 focus:ring-red-500">
                <span class="text-sm font-medium text-red-300">Saída</span>
            </label>
        </div>
        @error('tipo')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
    </div>

    {{-- Aluno (apenas para entradas) --}}
    <div id="campo-aluno" class="{{ $tipoAtual === 'entrada' ? '' : 'hidden' }}">
        <label for="user_id" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Aluno <span class="text-gray-500 normal-case font-normal">(opcional)</span></label>
        <select id="user_id" name="user_id"
                class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <option value="">— sem aluno vinculado —</option>
            @foreach($alunos as $a)
                <option value="{{ $a->id }}" {{ (int)$userIdAtual === (int)$a->id ? 'selected' : '' }}>
                    {{ $a->name }} ({{ $a->email }})
                </option>
            @endforeach
        </select>
        @error('user_id')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
    </div>

    {{-- Descrição --}}
    <div>
        <label for="descricao" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Descrição</label>
        <input type="text" id="descricao" name="descricao" value="{{ old('descricao', $movimentacao->descricao ?? '') }}" required
               placeholder="Ex.: Água, Luz, Pacote 8 aulas"
               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        @error('descricao')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
    </div>

    {{-- Valor + Data --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="valor" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Valor (R$)</label>
            <input type="number" step="0.01" min="0" id="valor" name="valor" value="{{ old('valor', isset($movimentacao) ? number_format((float)$movimentacao->valor, 2, '.', '') : '') }}" required placeholder="0.00"
                   class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('valor')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="data_vencimento" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Data de vencimento</label>
            <input type="date" id="data_vencimento" name="data_vencimento" required
                   value="{{ old('data_vencimento', isset($movimentacao) && $movimentacao->data_vencimento ? $movimentacao->data_vencimento->format('Y-m-d') : date('Y-m-d')) }}"
                   class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('data_vencimento')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
        </div>
    </div>

    {{-- Status + Data de pagamento --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="status" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Status</label>
            <select id="status" name="status"
                    class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="aberto" {{ $statusAtual === 'aberto' ? 'selected' : '' }}>Em aberto</option>
                <option value="atraso" {{ $statusAtual === 'atraso' ? 'selected' : '' }}>Em atraso</option>
                <option value="pago"   {{ $statusAtual === 'pago'   ? 'selected' : '' }}>Pago</option>
            </select>
            @error('status')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
        </div>
        <div id="campo-pagamento" class="{{ $statusAtual === 'pago' ? '' : 'hidden' }}">
            <label for="data_pagamento" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Data de pagamento</label>
            <input type="date" id="data_pagamento" name="data_pagamento"
                   value="{{ old('data_pagamento', isset($movimentacao) && $movimentacao->data_pagamento ? $movimentacao->data_pagamento->format('Y-m-d') : date('Y-m-d')) }}"
                   class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('data_pagamento')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
        </div>
    </div>

    {{-- Observações --}}
    <div>
        <label for="observacoes" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Observações <span class="text-gray-500 normal-case font-normal">(opcional)</span></label>
        <textarea id="observacoes" name="observacoes" rows="3"
                  placeholder="Ex.: Referente a 8 aulas, pago via PIX..."
                  class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none">{{ old('observacoes', $movimentacao->observacoes ?? '') }}</textarea>
        @error('observacoes')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
    </div>
</div>

<div class="flex items-center justify-end gap-2 px-6 py-4 border-t border-gray-800">
    <a href="{{ route('professor.movimentacoes.index') }}"
       class="text-sm font-medium px-4 py-2 rounded-md border border-gray-700 text-gray-300 hover:bg-gray-800 transition-colors">
        Cancelar
    </a>
    <button id="btnSalvarMov" type="submit"
            style="background-color: #2563eb; color: #ffffff;"
            onmouseover="this.style.backgroundColor='#1d4ed8'"
            onmouseout="this.style.backgroundColor='#2563eb'"
            class="inline-flex items-center text-sm font-medium px-4 py-2 rounded-md transition-colors">
        <span class="btn-spin inline-block align-middle w-3.5 h-3.5 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
        <span class="btn-text">{{ isset($movimentacao) ? 'Atualizar' : 'Salvar' }}</span>
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        // Mostra/esconde o campo de aluno conforme o tipo
        const tipoEntrada = document.getElementById('tipo-entrada');
        const tipoSaida   = document.getElementById('tipo-saida');
        const campoAluno  = document.getElementById('campo-aluno');
        const userSelect  = document.getElementById('user_id');

        function atualizarCampoAluno() {
            const isEntrada = tipoEntrada.checked;
            campoAluno.classList.toggle('hidden', !isEntrada);
            if (!isEntrada && userSelect) userSelect.value = '';
        }
        tipoEntrada?.addEventListener('change', atualizarCampoAluno);
        tipoSaida?.addEventListener('change', atualizarCampoAluno);

        // Mostra/esconde a data de pagamento conforme status
        const statusSel       = document.getElementById('status');
        const campoPagamento  = document.getElementById('campo-pagamento');
        statusSel?.addEventListener('change', () => {
            campoPagamento.classList.toggle('hidden', statusSel.value !== 'pago');
        });

        // Loading do botão de salvar
        const btn  = document.getElementById('btnSalvarMov');
        const form = btn?.closest('form');
        if (form && btn) {
            form.addEventListener('submit', function(){
                btn.disabled = true;
                btn.classList.add('opacity-70','cursor-not-allowed');
                const txt = btn.querySelector('.btn-text');
                const spn = btn.querySelector('.btn-spin');
                if (txt) txt.textContent = '{{ isset($movimentacao) ? 'Atualizando...' : 'Salvando...' }}';
                if (spn) spn.style.display = 'inline-block';
            }, { once: true });
        }
    });
</script>
