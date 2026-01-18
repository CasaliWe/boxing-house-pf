@extends('layouts.app')

@section('title', 'Meu Perfil')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-semibold text-blue-400 mb-4">👤 Meu Perfil</h1>
    @if($errors->any())
        <div class="mb-4 px-4 py-3 bg-red-700 text-white rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-gray-800 border border-gray-700 rounded-xl p-6">
        <form method="POST" action="{{ route('aluno.perfil.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-gray-300 text-sm">Nome</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-1 w-full bg-gray-900 border border-gray-700 rounded p-2 text-white" required>
                </div>
                <div>
                    <label class="text-gray-300 text-sm">WhatsApp</label>
                    <input type="text" id="whatsapp" name="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}" class="mt-1 w-full bg-gray-900 border border-gray-700 rounded p-2 text-white" placeholder="(54) 9 91234567">
                </div>
                <div>
                    <label class="text-gray-300 text-sm">Instagram</label>
                    <input type="text" id="instagram" name="instagram" value="{{ old('instagram', $user->instagram) }}" class="mt-1 w-full bg-gray-900 border border-gray-700 rounded p-2 text-white" placeholder="@seuinstagram">
                </div>
                <div>
                    <label class="text-gray-300 text-sm">Endereço</label>
                    <input type="text" name="endereco" value="{{ old('endereco', $user->endereco) }}" class="mt-1 w-full bg-gray-900 border border-gray-700 rounded p-2 text-white">
                </div>
                <div>
                    <label class="text-gray-300 text-sm">Contato de Emergência (Nome)</label>
                    <input type="text" name="contato_emergencia_nome" value="{{ old('contato_emergencia_nome', $user->contato_emergencia_nome) }}" class="mt-1 w-full bg-gray-900 border border-gray-700 rounded p-2 text-white">
                </div>
                <div>
                    <label class="text-gray-300 text-sm">Contato de Emergência (WhatsApp)</label>
                    <input type="text" id="contato_emergencia_whatsapp" name="contato_emergencia_whatsapp" value="{{ old('contato_emergencia_whatsapp', $user->contato_emergencia_whatsapp) }}" class="mt-1 w-full bg-gray-900 border border-gray-700 rounded p-2 text-white" placeholder="(54) 9 91234567">
                </div>
                <div>
                    <label class="text-gray-300 text-sm">Data de Nascimento</label>
                    <input type="date" name="data_nascimento" value="{{ old('data_nascimento', $user->data_nascimento) }}" class="mt-1 w-full bg-gray-900 border border-gray-700 rounded p-2 text-white">
                </div>
                <div>
                    <label class="text-gray-300 text-sm">Idade</label>
                    <input type="text" id="idade" name="idade" value="{{ old('idade', $user->idade) }}" class="mt-1 w-full bg-gray-900 border border-gray-700 rounded p-2 text-white" placeholder="Ex: 25">
                </div>
                <div>
                    <label class="text-gray-300 text-sm">Peso</label>
                    <input type="text" id="peso" name="peso" value="{{ old('peso', $user->peso) }}" class="mt-1 w-full bg-gray-900 border border-gray-700 rounded p-2 text-white" placeholder="Ex: 70.5">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-gray-300 text-sm">Nova senha</label>
                    <input type="password" name="password" class="mt-1 w-full bg-gray-900 border border-gray-700 rounded p-2 text-white">
                </div>
                <div>
                    <label class="text-gray-300 text-sm">Confirmar senha</label>
                    <input type="password" name="password_confirmation" class="mt-1 w-full bg-gray-900 border border-gray-700 rounded p-2 text-white">
                </div>
            </div>

            <div class="pt-2">
                <button id="btnSalvarPerfil" type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                    <span class="btn-spin inline-block align-middle w-4 h-4 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
                    <span class="btn-text">Salvar alterações</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    // Função para formatar WhatsApp
    function formatWhatsApp(value) {
        const digits = value.replace(/\D/g, '');
        const dd = digits.slice(0,2);
        const nine = digits.slice(2,3);
        const rest = digits.slice(3,11);
        let formatted = '';
        if(dd) formatted += '(' + dd + ')';
        if(nine) formatted += ' ' + nine;
        if(rest) formatted += ' ' + rest;
        return formatted.trim();
    }
    
    // Função para formatar Instagram
    function formatInstagram(value) {
        if (!value.startsWith('@') && value.length > 0) {
            return '@' + value;
        }
        return value;
    }
    
    // Função para números apenas
    function onlyNumbers(value) {
        return value.replace(/\D/g, '');
    }
    
    // Função para peso com decimal
    function formatWeight(value) {
        return value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
    }
    
    // Aplicar máscaras
    const whatsapp = document.getElementById('whatsapp');
    const instagram = document.getElementById('instagram');
    const whatsappEmergencia = document.getElementById('contato_emergencia_whatsapp');
    const idade = document.getElementById('idade');
    const peso = document.getElementById('peso');
    
    if(whatsapp) {
        whatsapp.addEventListener('input', function(){
            this.value = formatWhatsApp(this.value);
        });
    }
    
    if(instagram) {
        instagram.addEventListener('input', function(){
            this.value = formatInstagram(this.value);
        });
    }
    
    if(whatsappEmergencia) {
        whatsappEmergencia.addEventListener('input', function(){
            this.value = formatWhatsApp(this.value);
        });
    }
    
    if(idade) {
        idade.addEventListener('input', function(){
            this.value = onlyNumbers(this.value);
        });
    }
    
    if(peso) {
        peso.addEventListener('input', function(){
            this.value = formatWeight(this.value);
        });
    }
    
    // Loading no botão
    const btn = document.getElementById('btnSalvarPerfil');
    const form = btn.closest('form');
    if(form && btn){
        form.addEventListener('submit', function(){
            btn.disabled = true;
            btn.classList.add('opacity-70','cursor-not-allowed');
            const txt = btn.querySelector('.btn-text');
            const spn = btn.querySelector('.btn-spin');
            if(txt) txt.textContent = 'Salvando...';
            if(spn) spn.style.display = 'inline-block';
        }, { once: true });
    }
});
</script>
@endsection
