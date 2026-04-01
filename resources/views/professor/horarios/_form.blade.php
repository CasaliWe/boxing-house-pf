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
        <label for="dia_semana" class="block text-sm font-medium text-gray-300 mb-2">Dia da Semana</label>
        <select id="dia_semana" name="dia_semana" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Selecione...</option>
            @foreach($dias as $valor => $label)
                <option value="{{ $valor }}" {{ (old('dia_semana', $horario->dia_semana ?? '') == $valor) ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        @error('dia_semana')
            <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="hora_inicio" class="block text-sm font-medium text-gray-300 mb-2">Hora de Início</label>
            <input type="time" id="hora_inicio" name="hora_inicio" value="{{ old('hora_inicio', isset($horario) ? \Illuminate\Support\Str::of($horario->hora_inicio)->substr(0,5) : '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('hora_inicio')
                <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="hora_fim" class="block text-sm font-medium text-gray-300 mb-2">Hora de Fim</label>
            <input type="time" id="hora_fim" name="hora_fim" value="{{ old('hora_fim', isset($horario) ? \Illuminate\Support\Str::of($horario->hora_fim)->substr(0,5) : '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('hora_fim')
                <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div>
        <label for="vagas" class="block text-sm font-medium text-gray-300 mb-2">Vagas</label>
        <input type="number" id="vagas" name="vagas" min="1" max="10" value="{{ old('vagas', $horario->vagas ?? 3) }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="3">
        <p class="text-xs text-gray-400 mt-1">Quantidade máxima de alunos neste horário (1 a 10).</p>
        @error('vagas')
            <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
        @enderror
    </div>

    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('professor.horarios.index') }}" class="px-4 py-2 rounded-md border border-gray-600 text-gray-200 hover:bg-gray-700">Cancelar</a>
        <button id="btnSalvarHorario" type="submit" class="px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white">
            <span class="btn-spin inline-block align-middle w-4 h-4 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
            <span class="btn-text">{{ isset($horario) ? 'Atualizar' : 'Salvar' }}</span>
        </button>
    </div>

    <script>
    // Loading ao salvar/atualizar horário
    document.addEventListener('DOMContentLoaded', function(){
        const btn = document.getElementById('btnSalvarHorario');
        let form = btn;
        while(form && form.tagName !== 'FORM'){ form = form.parentElement; }
        if(form && btn){
            form.addEventListener('submit', function(){
                btn.disabled = true;
                btn.classList.add('opacity-70','cursor-not-allowed');
                const txt = btn.querySelector('.btn-text');
                const spn = btn.querySelector('.btn-spin');
                if(txt) txt.textContent = '{{ isset($horario) ? 'Atualizando...' : 'Salvando...' }}';
                if(spn) spn.style.display = 'inline-block';
            }, { once: true });
        }
    });
    </script>
</div>
