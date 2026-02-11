@extends('layouts.app')

@section('title', 'Cadastro - Etapa 1')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">
    <div class="text-center">
        <h1 class="text-3xl font-bold text-blue-400">📝 Cadastro - Etapa 1</h1>
        <p class="text-gray-400">Informações pessoais e de contato.</p>
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6 mb-16">
        <form method="POST" action="{{ route('cadastro.step1.post') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Nome completo</label>
                    <input type="text" name="name" value="{{ old('name', $data['name'] ?? '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white" required>
                    @error('name')<div class="text-red-400 text-sm mt-2">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">E-mail</label>
                    <input type="email" name="email" value="{{ old('email', $data['email'] ?? '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white" required>
                    @error('email')<div class="text-red-400 text-sm mt-2">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Idade</label>
                    <input id="inpIdade" type="text" name="idade" inputmode="numeric" pattern="[0-9]*" value="{{ old('idade', $data['idade'] ?? '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white" placeholder="Ex.: 28">
                    @error('idade')<div class="text-red-400 text-sm mt-2">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Peso (kg)</label>
                    <input id="inpPeso" type="text" name="peso" inputmode="decimal" value="{{ old('peso', $data['peso'] ?? '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white" placeholder="Ex.: 72,5">
                    @error('peso')<div class="text-red-400 text-sm mt-2">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Data de nascimento</label>
                    <input type="date" name="data_nascimento" value="{{ old('data_nascimento', $data['data_nascimento'] ?? '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white" required>
                    @error('data_nascimento')<div class="text-red-400 text-sm mt-2">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">WhatsApp</label>
                    <input id="inpWhatsapp" type="text" name="whatsapp" value="{{ old('whatsapp', $data['whatsapp'] ?? '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white" placeholder="(54) 9 91538488" required>
                    @error('whatsapp')<div class="text-red-400 text-sm mt-2">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Instagram (opcional)</label>
                    <input id="inpInstagram" type="text" name="instagram" value="{{ old('instagram', $data['instagram'] ?? '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white" placeholder="@seuusuário">
                    @error('instagram')<div class="text-red-400 text-sm mt-2">{{ $message }}</div>@enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Endereço</label>
                <input type="text" name="endereco" value="{{ old('endereco', $data['endereco'] ?? '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white" required>
                @error('endereco')<div class="text-red-400 text-sm mt-2">{{ $message }}</div>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Objetivo (pode marcar mais de um)</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @php
                        $objetivosSelecionados = old('objetivos', $data['objetivos'] ?? []);
                    @endphp
                    <label class="inline-flex items-center gap-3">
                        <input type="checkbox" name="objetivos[]" value="Perder peso" {{ in_array('Perder peso', $objetivosSelecionados) ? 'checked' : '' }} class="rounded bg-gray-800 border-gray-600 text-blue-500">
                        <span class="text-gray-300">Perder peso</span>
                    </label>
                    <label class="inline-flex items-center gap-3">
                        <input type="checkbox" name="objetivos[]" value="Condicionamento físico" {{ in_array('Condicionamento físico', $objetivosSelecionados) ? 'checked' : '' }} class="rounded bg-gray-800 border-gray-600 text-blue-500">
                        <span class="text-gray-300">Condicionamento físico</span>
                    </label>
                    <label class="inline-flex items-center gap-3">
                        <input type="checkbox" name="objetivos[]" value="Parte técnica" {{ in_array('Parte técnica', $objetivosSelecionados) ? 'checked' : '' }} class="rounded bg-gray-800 border-gray-600 text-blue-500">
                        <span class="text-gray-300">Parte técnica</span>
                    </label>
                    <label class="inline-flex items-center gap-3">
                        <input type="checkbox" name="objetivos[]" value="Diversão" {{ in_array('Diversão', $objetivosSelecionados) ? 'checked' : '' }} class="rounded bg-gray-800 border-gray-600 text-blue-500">
                        <span class="text-gray-300">Diversão</span>
                    </label>
                    <label class="inline-flex items-center gap-3">
                        <input type="checkbox" name="objetivos[]" value="Competir" {{ in_array('Competir', $objetivosSelecionados) ? 'checked' : '' }} class="rounded bg-gray-800 border-gray-600 text-blue-500">
                        <span class="text-gray-300">Competir</span>
                    </label>
                </div>
                @error('objetivos')<div class="text-red-400 text-sm mt-2">{{ $message }}</div>@enderror
                @error('objetivos.*')<div class="text-red-400 text-sm mt-2">{{ $message }}</div>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Contato de Emergência - Nome</label>
                    <input type="text" name="contato_emergencia_nome" value="{{ old('contato_emergencia_nome', $data['contato_emergencia_nome'] ?? '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white" required>
                    @error('contato_emergencia_nome')<div class="text-red-400 text-sm mt-2">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Contato de Emergência - WhatsApp</label>
                    <input id="inpWhatsappEmerg" type="text" name="contato_emergencia_whatsapp" value="{{ old('contato_emergencia_whatsapp', $data['contato_emergencia_whatsapp'] ?? '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white" placeholder="(54) 9 91538488" required>
                    @error('contato_emergencia_whatsapp')<div class="text-red-400 text-sm mt-2">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <label class="inline-flex items-center gap-3">
                    <input id="chkSaude" type="checkbox" name="saude_problema" value="1" {{ old('saude_problema', $data['saude_problema'] ?? false) ? 'checked' : '' }} class="rounded bg-gray-800 border-gray-600 text-blue-500">
                    <span class="text-gray-300">Possui algum problema de saúde?</span>
                </label>
                <label class="inline-flex items-center gap-3">
                    <input id="chkRestricao" type="checkbox" name="restricao_medica" value="1" {{ old('restricao_medica', $data['restricao_medica'] ?? false) ? 'checked' : '' }} class="rounded bg-gray-800 border-gray-600 text-blue-500">
                    <span class="text-gray-300">Possui restrição médica/física?</span>
                </label>
            </div>
                <div id="saudeDescricaoWrap" class="mt-4" style="display: none;">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Descreva o problema de saúde</label>
                    <textarea name="saude_descricao" rows="3" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white">{{ old('saude_descricao', $data['saude_descricao'] ?? '') }}</textarea>
                    @error('saude_descricao')<div class="text-red-400 text-sm mt-2">{{ $message }}</div>@enderror
                </div>

                <div id="restricaoDescricaoWrap" class="mt-4" style="display: none;">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Descreva a restrição médica/física</label>
                    <textarea name="restricao_descricao" rows="3" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white">{{ old('restricao_descricao', $data['restricao_descricao'] ?? '') }}</textarea>
                    @error('restricao_descricao')<div class="text-red-400 text-sm mt-2">{{ $message }}</div>@enderror
                </div>

            <div class="flex justify-end">
    <script>
    function toggleAreas(){
        const s = document.getElementById('chkSaude');
        const r = document.getElementById('chkRestricao');
        const sWrap = document.getElementById('saudeDescricaoWrap');
        const rWrap = document.getElementById('restricaoDescricaoWrap');
        if(s) sWrap.style.display = s.checked ? 'block' : 'none';
        if(r) rWrap.style.display = r.checked ? 'block' : 'none';
    }

    function onlyDigits(str){ return (str||'').replace(/\D+/g,''); }
    function formatWhatsapp(raw){
        const d = onlyDigits(raw);
        const dd = d.slice(0,2);
        const nine = d.slice(2,3);
        const rest = d.slice(3,11);
        let out = '';
        if(dd){ out += '('+dd+')'; }
        if(nine){ out += ' '+nine; }
        if(rest){ out += ' '+rest; }
        return out.trim();
    }
    function formatIdade(raw){
        return onlyDigits(raw).slice(0,3); // até 3 dígitos
    }
    function formatPeso(raw){
        // usa vírgula como separador; máximo 3 inteiros + 1-2 decimais
        const cleaned = raw.replace(/[^0-9,\.]/g,'').replace(/\./g,',');
        const parts = cleaned.split(',');
        let int = onlyDigits(parts[0]).slice(0,3);
        let dec = parts[1] ? onlyDigits(parts[1]).slice(0,2) : '';
        return dec ? int+','+dec : int;
    }
    function ensureInstagramAt(raw){
        raw = (raw||'').trim();
        if(!raw) return '';
        if(raw.charAt(0) !== '@') raw = '@'+raw.replace(/^@+/,'');
        return raw.replace(/\s+/g,'');
    }

    document.addEventListener('DOMContentLoaded', function(){
        const s = document.getElementById('chkSaude');
        const r = document.getElementById('chkRestricao');
        if(s){ s.addEventListener('change', toggleAreas); }
        if(r){ r.addEventListener('change', toggleAreas); }
        toggleAreas();

        const inpWa = document.getElementById('inpWhatsapp');
        const inpWaE = document.getElementById('inpWhatsappEmerg');
        const inpId = document.getElementById('inpIdade');
        const inpPe = document.getElementById('inpPeso');
        const inpIg = document.getElementById('inpInstagram');

        function bindWhats(el){ if(!el) return; el.addEventListener('input', ()=>{ el.value = formatWhatsapp(el.value); }); }
        bindWhats(inpWa); bindWhats(inpWaE);
        if(inpId){ inpId.addEventListener('input', ()=>{ inpId.value = formatIdade(inpId.value); }); }
        if(inpPe){ inpPe.addEventListener('input', ()=>{ inpPe.value = formatPeso(inpPe.value); }); }
        if(inpIg){
            inpIg.addEventListener('input', ()=>{ inpIg.value = ensureInstagramAt(inpIg.value); });
            inpIg.addEventListener('blur', ()=>{ inpIg.value = ensureInstagramAt(inpIg.value); });
        }

        const form = document.querySelector('form[action="{{ route('cadastro.step1.post') }}"]');
        if(form){
            form.addEventListener('submit', function(){
                const btn = form.querySelector('#btnAvancar');
                if(btn){
                    btn.disabled = true;
                    btn.classList.add('opacity-70','cursor-not-allowed');
                    const txt = btn.querySelector('.btn-text');
                    const spn = btn.querySelector('.btn-spin');
                    if(txt) txt.textContent = 'Carregando...';
                    if(spn) spn.classList.remove('hidden');
                }
            });
        }
    });
    </script>
                <button id="btnAvancar" type="submit" class="px-5 py-3 rounded-md bg-blue-600 hover:bg-blue-700 text-white flex items-center gap-2">
                    <span class="btn-spin hidden w-4 h-4 border-2 border-white/60 border-t-transparent rounded-full animate-spin"></span>
                    <span class="btn-text">Avançar</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
