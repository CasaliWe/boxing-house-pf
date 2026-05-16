@php
    // Dias da semana usados pelo select
    $dias = [
        1 => 'Segunda-feira',
        2 => 'Terça-feira',
        3 => 'Quarta-feira',
        4 => 'Quinta-feira',
        5 => 'Sexta-feira',
        6 => 'Sábado',
        7 => 'Domingo',
    ];
@endphp

<div class="p-6 space-y-5">
    <div>
        <label for="nome" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Nome da pessoa</label>
        <input type="text" id="nome" name="nome" value="{{ old('nome', $aula->nome ?? '') }}"
               placeholder="Nome de quem marcou a aula"
               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        @error('nome')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label for="data" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Data</label>
            <input type="date" id="data" name="data" value="{{ old('data', isset($aula) ? $aula->data->format('Y-m-d') : '') }}"
                   class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('data')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="dia_semana" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Dia da semana</label>
            <select id="dia_semana" name="dia_semana"
                    class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Selecione...</option>
                @foreach($dias as $valor => $label)
                    <option value="{{ $valor }}" {{ (old('dia_semana', $aula->dia_semana ?? '') == $valor) ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @error('dia_semana')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="horario" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Horário</label>
            <input type="time" id="horario" name="horario" value="{{ old('horario', isset($aula) ? \Illuminate\Support\Str::of($aula->horario)->substr(0,5) : '') }}"
                   class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('horario')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
        </div>
    </div>

    <div>
        <label for="numero" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Telefone <span class="text-gray-500 normal-case font-normal">(opcional)</span></label>
        <input type="text" id="numero" name="numero" value="{{ old('numero', $aula->numero ?? '') }}" placeholder="(54) 9 9999-9999"
               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        @error('numero')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
    </div>

    <div>
        <label for="observacao" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Observação <span class="text-gray-500 normal-case font-normal">(opcional)</span></label>
        <textarea id="observacao" name="observacao" rows="3" placeholder="Alguma observação sobre esta aula..."
                  class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none">{{ old('observacao', $aula->observacao ?? '') }}</textarea>
        @error('observacao')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
    </div>
</div>

<div class="flex items-center justify-end gap-2 px-6 py-4 border-t border-gray-800">
    <a href="{{ route('professor.aulas-exp.index') }}"
       class="text-sm font-medium px-4 py-2 rounded-md border border-gray-700 text-gray-300 hover:bg-gray-800 transition-colors">
        Cancelar
    </a>
    <button id="btnSalvarAulaExp" type="submit"
            style="background-color: #2563eb; color: #ffffff;"
            onmouseover="this.style.backgroundColor='#1d4ed8'"
            onmouseout="this.style.backgroundColor='#2563eb'"
            class="inline-flex items-center text-sm font-medium px-4 py-2 rounded-md transition-colors">
        <span class="btn-spin inline-block align-middle w-3.5 h-3.5 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
        <span class="btn-text">{{ isset($aula) ? 'Atualizar' : 'Salvar' }}</span>
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        // Ao escolher uma data, preenche o dia da semana automaticamente
        const dataInput = document.getElementById('data');
        const diaSelect = document.getElementById('dia_semana');
        if (dataInput && diaSelect) {
            dataInput.addEventListener('change', function(){
                if (this.value) {
                    const d = new Date(this.value + 'T12:00:00');
                    let dia = d.getDay();           // 0=Domingo .. 6=Sábado
                    dia = dia === 0 ? 7 : dia;      // converte para 1=Seg .. 7=Dom
                    diaSelect.value = dia;
                }
            });
        }

        // Loading no botão de salvar
        const btn = document.getElementById('btnSalvarAulaExp');
        let form  = btn;
        while (form && form.tagName !== 'FORM') { form = form.parentElement; }
        if (form && btn) {
            form.addEventListener('submit', function(){
                btn.disabled = true;
                btn.classList.add('opacity-70','cursor-not-allowed');
                const txt = btn.querySelector('.btn-text');
                const spn = btn.querySelector('.btn-spin');
                if (txt) txt.textContent = '{{ isset($aula) ? 'Atualizando...' : 'Salvando...' }}';
                if (spn) spn.style.display = 'inline-block';
            }, { once: true });
        }
    });
</script>
