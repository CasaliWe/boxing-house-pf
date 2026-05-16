@php
    // Dias da semana
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
        <label for="dia_semana" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Dia da semana</label>
        <select id="dia_semana" name="dia_semana"
                class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <option value="">Selecione...</option>
            @foreach($dias as $valor => $label)
                <option value="{{ $valor }}" {{ (old('dia_semana', $horario->dia_semana ?? '') == $valor) ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        @error('dia_semana')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="hora_inicio" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Hora de início</label>
            <input type="time" id="hora_inicio" name="hora_inicio" value="{{ old('hora_inicio', isset($horario) ? \Illuminate\Support\Str::of($horario->hora_inicio)->substr(0,5) : '') }}"
                   class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('hora_inicio')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="hora_fim" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Hora de fim</label>
            <input type="time" id="hora_fim" name="hora_fim" value="{{ old('hora_fim', isset($horario) ? \Illuminate\Support\Str::of($horario->hora_fim)->substr(0,5) : '') }}"
                   class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('hora_fim')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
        </div>
    </div>

    <div>
        <label for="vagas" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Vagas</label>
        <input type="number" id="vagas" name="vagas" min="1" max="10" value="{{ old('vagas', $horario->vagas ?? 3) }}" placeholder="3"
               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <p class="text-xs text-gray-500 mt-1.5">Quantidade máxima de alunos neste horário (1 a 10).</p>
        @error('vagas')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
    </div>
</div>

<div class="flex items-center justify-end gap-2 px-6 py-4 border-t border-gray-800">
    <a href="{{ route('professor.horarios.index') }}"
       class="text-sm font-medium px-4 py-2 rounded-md border border-gray-700 text-gray-300 hover:bg-gray-800 transition-colors">
        Cancelar
    </a>
    <button id="btnSalvarHorario" type="submit"
            style="background-color: #2563eb; color: #ffffff;"
            onmouseover="this.style.backgroundColor='#1d4ed8'"
            onmouseout="this.style.backgroundColor='#2563eb'"
            class="inline-flex items-center text-sm font-medium px-4 py-2 rounded-md transition-colors">
        <span class="btn-spin inline-block align-middle w-3.5 h-3.5 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
        <span class="btn-text">{{ isset($horario) ? 'Atualizar' : 'Salvar' }}</span>
    </button>
</div>

<script>
    // Loading no botão ao submeter
    document.addEventListener('DOMContentLoaded', function(){
        const btn = document.getElementById('btnSalvarHorario');
        let form  = btn;
        while (form && form.tagName !== 'FORM') { form = form.parentElement; }
        if (form && btn) {
            form.addEventListener('submit', function(){
                btn.disabled = true;
                btn.classList.add('opacity-70','cursor-not-allowed');
                const txt = btn.querySelector('.btn-text');
                const spn = btn.querySelector('.btn-spin');
                if (txt) txt.textContent = '{{ isset($horario) ? 'Atualizando...' : 'Salvando...' }}';
                if (spn) spn.style.display = 'inline-block';
            }, { once: true });
        }
    });
</script>
