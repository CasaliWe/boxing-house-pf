@extends('layouts.app')

@section('title', 'Cadastro - Etapa 1')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">
    <div class="text-center">
        <h1 class="text-3xl font-bold text-blue-400">📝 Cadastro - Etapa 1</h1>
        <p class="text-gray-400">Informações pessoais e de contato.</p>
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
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
                    <input type="number" name="idade" min="1" max="120" value="{{ old('idade', $data['idade'] ?? '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white">
                    @error('idade')<div class="text-red-400 text-sm mt-2">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Peso (kg)</label>
                    <input type="number" name="peso" step="0.1" value="{{ old('peso', $data['peso'] ?? '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white">
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
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $data['whatsapp'] ?? '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white" required>
                    @error('whatsapp')<div class="text-red-400 text-sm mt-2">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Instagram (opcional)</label>
                    <input type="text" name="instagram" value="{{ old('instagram', $data['instagram'] ?? '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white">
                    @error('instagram')<div class="text-red-400 text-sm mt-2">{{ $message }}</div>@enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Endereço</label>
                <input type="text" name="endereco" value="{{ old('endereco', $data['endereco'] ?? '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white" required>
                @error('endereco')<div class="text-red-400 text-sm mt-2">{{ $message }}</div>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Contato de Emergência - Nome</label>
                    <input type="text" name="contato_emergencia_nome" value="{{ old('contato_emergencia_nome', $data['contato_emergencia_nome'] ?? '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white" required>
                    @error('contato_emergencia_nome')<div class="text-red-400 text-sm mt-2">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Contato de Emergência - WhatsApp</label>
                    <input type="text" name="contato_emergencia_whatsapp" value="{{ old('contato_emergencia_whatsapp', $data['contato_emergencia_whatsapp'] ?? '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white" required>
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
    document.addEventListener('DOMContentLoaded', function(){
        const s = document.getElementById('chkSaude');
        const r = document.getElementById('chkRestricao');
        if(s){ s.addEventListener('change', toggleAreas); }
        if(r){ r.addEventListener('change', toggleAreas); }
        toggleAreas();
    });
    </script>
                <button type="submit" class="px-5 py-3 rounded-md bg-blue-600 hover:bg-blue-700 text-white">Avançar</button>
            </div>
        </form>
    </div>
</div>
@endsection
