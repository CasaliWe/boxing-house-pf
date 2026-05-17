@extends('layouts.app')

@section('title', 'Meu Perfil')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Cabeçalho da página --}}
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Meu Perfil</h1>
            <p class="text-sm text-gray-400 mt-1">Mantenha seus dados atualizados</p>
        </div>
    </div>

    {{-- Erros de validação --}}
    @if($errors->any())
        <div class="bg-red-500/10 border border-red-500/40 rounded-lg p-4">
            <ul class="text-sm text-red-200 list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('aluno.perfil.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Dados pessoais --}}
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-800 flex items-center gap-3">
                <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-white">Dados pessoais</h3>
                    <p class="text-xs text-gray-400">Informações básicas e de contato</p>
                </div>
            </div>

            <div class="p-4 sm:p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Nome</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">WhatsApp</label>
                    <input type="text" id="whatsapp" name="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}" placeholder="(54) 9 91234567"
                           class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Instagram</label>
                    <input type="text" id="instagram" name="instagram" value="{{ old('instagram', $user->instagram) }}" placeholder="@seuinstagram"
                           class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Endereço</label>
                    <input type="text" name="endereco" value="{{ old('endereco', $user->endereco) }}"
                           class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Data de Nascimento</label>
                    <input type="date" name="data_nascimento" value="{{ old('data_nascimento', $user->data_nascimento ? \Illuminate\Support\Carbon::parse($user->data_nascimento)->format('Y-m-d') : '') }}"
                           class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Idade</label>
                        <input type="text" id="idade" name="idade" value="{{ old('idade', $user->idade) }}" placeholder="Ex: 25"
                               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Peso (kg)</label>
                        <input type="text" id="peso" name="peso" value="{{ old('peso', $user->peso) }}" placeholder="Ex: 70.5"
                               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
            </div>
        </div>

        {{-- Contato de emergência --}}
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-800 flex items-center gap-3">
                <div class="w-9 h-9 rounded-md bg-red-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-white">Contato de emergência</h3>
                    <p class="text-xs text-gray-400">Quem deve ser avisado em caso de necessidade</p>
                </div>
            </div>

            <div class="p-4 sm:p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Nome</label>
                    <input type="text" name="contato_emergencia_nome" value="{{ old('contato_emergencia_nome', $user->contato_emergencia_nome) }}"
                           class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">WhatsApp</label>
                    <input type="text" id="contato_emergencia_whatsapp" name="contato_emergencia_whatsapp" value="{{ old('contato_emergencia_whatsapp', $user->contato_emergencia_whatsapp) }}" placeholder="(54) 9 91234567"
                           class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
        </div>

        {{-- Objetivos --}}
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-800 flex items-center gap-3">
                <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-white">Objetivos</h3>
                    <p class="text-xs text-gray-400">Pode marcar mais de um</p>
                </div>
            </div>

            <div class="p-4 sm:p-6">
                @php $objetivosSelecionados = old('objetivos', $user->objetivos ?? []); @endphp
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    @foreach(['Perder peso', 'Condicionamento físico', 'Parte técnica', 'Diversão', 'Competir'] as $obj)
                        <label class="flex items-center gap-2.5 bg-gray-800/40 border border-gray-700 hover:border-blue-500/40 rounded-md px-3 py-2.5 cursor-pointer transition-colors">
                            <input type="checkbox" name="objetivos[]" value="{{ $obj }}"
                                   {{ in_array($obj, $objetivosSelecionados) ? 'checked' : '' }}
                                   class="rounded bg-gray-900 border-gray-700 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-gray-200">{{ $obj }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Senha --}}
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-800 flex items-center gap-3">
                <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-white">Alterar senha</h3>
                    <p class="text-xs text-gray-400">Deixe em branco para manter a senha atual</p>
                </div>
            </div>

            <div class="p-4 sm:p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Nova senha</label>
                    <input type="password" name="password"
                           class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Confirmar senha</label>
                    <input type="password" name="password_confirmation"
                           class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
        </div>

        {{-- Ações --}}
        <div class="flex justify-end">
            <button id="btnSalvarPerfil" type="submit"
                    style="background-color: #2563eb; color: #ffffff;"
                    onmouseover="this.style.backgroundColor='#1d4ed8'"
                    onmouseout="this.style.backgroundColor='#2563eb'"
                    class="inline-flex items-center text-sm font-medium px-5 py-2 rounded-md transition-colors">
                <span class="btn-spin inline-block align-middle w-3.5 h-3.5 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
                <span class="btn-text">Salvar alterações</span>
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        // Formata número de WhatsApp como (XX) X XXXXXXXX
        function formatWhatsApp(value) {
            const digits = value.replace(/\D/g, '');
            const dd     = digits.slice(0, 2);
            const nine   = digits.slice(2, 3);
            const rest   = digits.slice(3, 11);
            let out = '';
            if (dd)   out += '(' + dd + ')';
            if (nine) out += ' ' + nine;
            if (rest) out += ' ' + rest;
            return out.trim();
        }

        // Garante que o instagram começa com @
        function formatInstagram(value) {
            return (!value.startsWith('@') && value.length > 0) ? '@' + value : value;
        }

        // Mantém apenas dígitos
        const onlyNumbers  = (v) => v.replace(/\D/g, '');
        // Mantém dígitos + um único ponto decimal
        const formatWeight = (v) => v.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');

        // Aplica máscaras
        const whatsapp           = document.getElementById('whatsapp');
        const instagram          = document.getElementById('instagram');
        const whatsappEmergencia = document.getElementById('contato_emergencia_whatsapp');
        const idade              = document.getElementById('idade');
        const peso               = document.getElementById('peso');

        if (whatsapp)           whatsapp.addEventListener('input', e => e.target.value = formatWhatsApp(e.target.value));
        if (instagram)          instagram.addEventListener('input', e => e.target.value = formatInstagram(e.target.value));
        if (whatsappEmergencia) whatsappEmergencia.addEventListener('input', e => e.target.value = formatWhatsApp(e.target.value));
        if (idade)              idade.addEventListener('input', e => e.target.value = onlyNumbers(e.target.value));
        if (peso)               peso.addEventListener('input', e => e.target.value = formatWeight(e.target.value));

        // Loading no botão de salvar
        const btn  = document.getElementById('btnSalvarPerfil');
        const form = btn?.closest('form');
        if (form && btn) {
            form.addEventListener('submit', function() {
                btn.disabled = true;
                btn.classList.add('opacity-70','cursor-not-allowed');
                const txt = btn.querySelector('.btn-text');
                const spn = btn.querySelector('.btn-spin');
                if (txt) txt.textContent = 'Salvando...';
                if (spn) spn.style.display = 'inline-block';
            }, { once: true });
        }
    });
</script>
@endsection
