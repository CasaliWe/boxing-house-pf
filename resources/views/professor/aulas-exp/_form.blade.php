@php
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

<div class="space-y-6">
    <div>
        <label for="nome" class="block text-sm font-medium text-gray-300 mb-2">Nome da Pessoa</label>
        <input type="text" id="nome" name="nome" value="{{ old('nome', $aula->nome ?? '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nome de quem marcou a aula">
        @error('nome')
            <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <label for="data" class="block text-sm font-medium text-gray-300 mb-2">Data</label>
            <input type="date" id="data" name="data" value="{{ old('data', isset($aula) ? $aula->data->format('Y-m-d') : '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('data')
                <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="dia_semana" class="block text-sm font-medium text-gray-300 mb-2">Dia da Semana</label>
            <select id="dia_semana" name="dia_semana" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Selecione...</option>
                @foreach($dias as $valor => $label)
                    <option value="{{ $valor }}" {{ (old('dia_semana', $aula->dia_semana ?? '') == $valor) ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @error('dia_semana')
                <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="horario" class="block text-sm font-medium text-gray-300 mb-2">Horário</label>
            <input type="time" id="horario" name="horario" value="{{ old('horario', isset($aula) ? \Illuminate\Support\Str::of($aula->horario)->substr(0,5) : '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('horario')
                <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div>
        <label for="numero" class="block text-sm font-medium text-gray-300 mb-2">Número / Telefone (opcional)</label>
        <input type="text" id="numero" name="numero" value="{{ old('numero', $aula->numero ?? '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="(54) 9 9999-9999">
        @error('numero')
            <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="observacao" class="block text-sm font-medium text-gray-300 mb-2">Observação (opcional)</label>
        <textarea id="observacao" name="observacao" rows="3" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Alguma observação sobre esta aula...">{{ old('observacao', $aula->observacao ?? '') }}</textarea>
        @error('observacao')
            <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
        @enderror
    </div>

    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('professor.aulas-exp.index') }}" class="px-4 py-2 rounded-md border border-gray-600 text-gray-200 hover:bg-gray-700">Cancelar</a>
        <button id="btnSalvarAulaExp" type="submit" class="px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white">
            <span class="btn-spin inline-block align-middle w-4 h-4 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
            <span class="btn-text">{{ isset($aula) ? 'Atualizar' : 'Salvar' }}</span>
        </button>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function(){
        // Auto-preencher dia da semana ao selecionar data
        const dataInput = document.getElementById('data');
        const diaSelect = document.getElementById('dia_semana');
        if(dataInput && diaSelect){
            dataInput.addEventListener('change', function(){
                if(this.value){
                    const d = new Date(this.value + 'T12:00:00');
                    // getDay: 0=Domingo, 1=Segunda... converter para 1=Segunda, 7=Domingo
                    let dia = d.getDay();
                    dia = dia === 0 ? 7 : dia;
                    diaSelect.value = dia;
                }
            });
        }

        // Loading no botão
        const btn = document.getElementById('btnSalvarAulaExp');
        let form = btn;
        while(form && form.tagName !== 'FORM'){ form = form.parentElement; }
        if(form && btn){
            form.addEventListener('submit', function(){
                btn.disabled = true;
                btn.classList.add('opacity-70','cursor-not-allowed');
                const txt = btn.querySelector('.btn-text');
                const spn = btn.querySelector('.btn-spin');
                if(txt) txt.textContent = '{{ isset($aula) ? 'Atualizando...' : 'Salvando...' }}';
                if(spn) spn.style.display = 'inline-block';
            }, { once: true });
        }
    });
    </script>
</div>
