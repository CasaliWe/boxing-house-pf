@extends('layouts.app')

@section('title', 'Configurações')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold text-blue-400">⚙️ Configurações</h1>
        <p class="text-gray-400">Atualize informações da academia: PIX, WhatsApp, Maps (src) e e-mail.</p>
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        <form method="POST" action="{{ route('professor.config.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="pix" class="block text-sm font-medium text-gray-300 mb-2">Chave PIX</label>
                    <input type="text" id="pix" name="pix" value="{{ old('pix', $config->pix) }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ex.: chave@pix.com ou CPF/CNPJ">
                    @error('pix')
                        <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="whatsapp" class="block text-sm font-medium text-gray-300 mb-2">WhatsApp da Academia</label>
                    <input type="text" id="whatsapp" name="whatsapp" value="{{ old('whatsapp', $config->whatsapp) }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="(54) 9 91538488">
                    @error('whatsapp')
                        <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div>
                <label for="maps_src" class="block text-sm font-medium text-gray-300 mb-2">Google Maps (conteúdo do src)</label>
                <input type="text" id="maps_src" name="maps_src" value="{{ old('maps_src', $config->maps_src) }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Cole aqui apenas o conteúdo do src do iframe">
                @error('maps_src')
                    <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                @enderror
                <p class="text-xs text-gray-400 mt-2">Dica: ao incorporar o Google Maps, copie apenas o que aparece dentro do atributo <span class="text-gray-200">src="..."</span>.</p>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-300 mb-2">E-mail da Academia</label>
                <input type="email" id="email" name="email" value="{{ old('email', $config->email) }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ex.: contato@boxinghousepf.com">
                @error('email')
                    <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3">
                <button type="submit" class="px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white">Salvar</button>
            </div>
        </form>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function(){
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
    const wa = document.getElementById('whatsapp');
    if(wa){
        wa.addEventListener('input', function(){ wa.value = formatWhatsapp(wa.value); });
        wa.addEventListener('blur', function(){ wa.value = formatWhatsapp(wa.value); });
    }
});
</script>
@endsection
