@extends('layouts.app')

@section('title', 'Configurações')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold text-blue-400">⚙️ Configurações</h1>
        <p class="text-gray-400">Atualize informações da academia: PIX, WhatsApp, Maps (src), e-mail e configurações da API WhatsApp.</p>
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

            <div>
                <label for="instagram" class="block text-sm font-medium text-gray-300 mb-2">Instagram (@usuário)</label>
                <input type="text" id="instagram" name="instagram" value="{{ old('instagram', $config->instagram) }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ex.: @boxinghousepf">
                @error('instagram')
                    <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Seção API WhatsApp -->
            <div class="border-t border-gray-600 pt-6">
                <h3 class="text-lg font-semibold text-blue-400 mb-4">🔌 Configurações API WhatsApp</h3>
                <p class="text-sm text-gray-400 mb-4">Configure as credenciais da API uazapi para envio automático de mensagens WhatsApp</p>
                
                <div class="bg-blue-900/20 border border-blue-500/30 rounded-lg p-4 mb-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-300">
                                <span class="font-medium">Informação:</span> Se deixados em branco, o sistema utilizará valores padrão para as configurações da API.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="whatsapp_api_url" class="block text-sm font-medium text-gray-300 mb-2">URL da API uazapi</label>
                        <input type="url" id="whatsapp_api_url" name="whatsapp_api_url" value="{{ old('whatsapp_api_url', $config->whatsapp_api_url) }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ex.: https://api.uazapi.com">
                        @error('whatsapp_api_url')
                            <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Deixe em branco para usar valor padrão</p>
                    </div>

                    <div>
                        <label for="whatsapp_api_token" class="block text-sm font-medium text-gray-300 mb-2">Token da API</label>
                        <input type="text" id="whatsapp_api_token" name="whatsapp_api_token" value="{{ old('whatsapp_api_token', $config->whatsapp_api_token) }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Token de autorização da uazapi">
                        @error('whatsapp_api_token')
                            <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Deixe em branco para usar valor padrão</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="cidade" class="block text-sm font-medium text-gray-300 mb-2">Cidade</label>
                    <input type="text" id="cidade" name="cidade" value="{{ old('cidade', $config->cidade) }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ex.: Passo Fundo">
                    @error('cidade')
                        <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="bairro" class="block text-sm font-medium text-gray-300 mb-2">Bairro</label>
                    <input type="text" id="bairro" name="bairro" value="{{ old('bairro', $config->bairro) }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ex.: Centro">
                    @error('bairro')
                        <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <label for="rua" class="block text-sm font-medium text-gray-300 mb-2">Rua/Avenida</label>
                    <input type="text" id="rua" name="rua" value="{{ old('rua', $config->rua) }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ex.: Rua Teixeira Soares">
                    @error('rua')
                        <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="numero" class="block text-sm font-medium text-gray-300 mb-2">Número</label>
                    <input type="text" id="numero" name="numero" value="{{ old('numero', $config->numero) }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ex.: 123">
                    @error('numero')
                        <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <button id="btnSalvarConfig" type="submit" class="px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white">
                    <span class="btn-spin inline-block align-middle w-4 h-4 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
                    <span class="btn-text">Salvar</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Fotos do Centro de Treinamento -->
    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            <div>
                <h2 class="text-xl font-semibold text-blue-400 mb-2">📸 Fotos do Centro de Treinamento</h2>
                <p class="text-gray-400 text-sm">Gerencie as fotos que aparecerão na landing page da academia.</p>
            </div>
            <button onclick="abrirModalFoto()" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Adicionar Foto
            </button>
        </div>

        @if($fotosCentro->isEmpty())
            <div class="text-center py-12 border-2 border-dashed border-gray-600 rounded-lg">
                <div class="text-6xl mb-4">📷</div>
                <h3 class="text-xl font-semibold text-gray-400 mb-2">Nenhuma foto adicionada</h3>
                <p class="text-gray-500 mb-4">Adicione fotos do seu centro de treinamento para exibir na landing page.</p>
                <button onclick="abrirModalFoto()" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                    Adicionar Primeira Foto
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($fotosCentro as $foto)
                    <div class="bg-gray-800 rounded-lg overflow-hidden hover:bg-gray-700 transition-colors">
                        <div class="aspect-video overflow-hidden">
                            <img src="{{ asset($foto->caminho_arquivo) }}" alt="{{ $foto->nome_original }}" 
                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                        </div>
                        <div class="p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-white font-medium text-sm truncate">{{ $foto->nome_original }}</h4>
                                    @if($foto->descricao)
                                        <p class="text-gray-400 text-xs mt-1">{{ $foto->descricao }}</p>
                                    @endif
                                    <span class="text-xs text-gray-500 mt-1">Ordem: {{ $foto->ordem }}</span>
                                </div>
                                <button onclick="confirmarExclusaoFoto({{ $foto->id }}, '{{ addslashes($foto->nome_original) }}')" 
                                        class="px-2 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs transition-colors flex-shrink-0">
                                    Excluir
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<!-- Modal Adicionar Foto -->
<div id="modalFoto" class="fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-4" style="display:none">
    <div class="bg-gray-800 rounded-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-white">Adicionar Foto</h3>
            <button onclick="fecharModalFoto()" class="text-gray-400 hover:text-white p-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <form id="formFoto" method="POST" action="{{ route('professor.config.fotos.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">📸 Selecionar Foto</label>
                    <input type="file" id="foto" name="foto" accept="image/*" required 
                           class="w-full bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-xs text-gray-400 mt-1">Formatos aceitos: JPG, PNG, GIF. Máximo: 5MB</p>
                </div>
                
                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">📝 Descrição (opcional)</label>
                    <input type="text" id="descricao" name="descricao" 
                           class="w-full bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Ex: Área de treino principal">
                </div>
            </div>
            
            <div class="flex gap-3 mt-6">
                <button id="btnSalvarFoto" type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors flex-1">
                    <span class="btn-spin inline-block align-middle w-4 h-4 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
                    <span class="btn-text">Adicionar Foto</span>
                </button>
                <button type="button" onclick="fecharModalFoto()" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão de Foto -->
<div id="modalExclusaoFoto" class="fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-4" style="display:none">
    <div class="bg-gray-800 rounded-xl p-6 w-full max-w-md">
        <div class="flex items-center gap-3 mb-4">
            <div class="text-red-500 text-2xl">⚠️</div>
            <h3 class="text-xl font-semibold text-white">Confirmar Exclusão</h3>
        </div>
        
        <p class="text-gray-300 mb-6">
            Tem certeza que deseja excluir a foto "<span id="nomeFotoExclusao" class="font-semibold text-white"></span>"?
            <br><span class="text-sm text-red-400">Esta ação não pode ser desfeita.</span>
        </p>
        
        <div class="flex gap-3">
            <form id="formExclusaoFoto" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                    Sim, Excluir
                </button>
            </form>
            <button onclick="fecharModalExclusaoFoto()" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                Cancelar
            </button>
        </div>
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
    
    // Loading no formulário de config
    const btn = document.getElementById('btnSalvarConfig');
    const form = btn ? btn.closest('form') : null;
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

    // Loading no formulário de foto
    const btnFoto = document.getElementById('btnSalvarFoto');
    const formFoto = btnFoto ? btnFoto.closest('form') : null;
    if(formFoto && btnFoto){
        formFoto.addEventListener('submit', function(){
            btnFoto.disabled = true;
            btnFoto.classList.add('opacity-70','cursor-not-allowed');
            const txt = btnFoto.querySelector('.btn-text');
            const spn = btnFoto.querySelector('.btn-spin');
            if(txt) txt.textContent = 'Enviando...';
            if(spn) spn.style.display = 'inline-block';
        }, { once: true });
    }

    // Fechar modais com ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            fecharModalFoto();
            fecharModalExclusaoFoto();
        }
    });
});

// Funções dos modais de foto
function abrirModalFoto() {
    document.getElementById('modalFoto').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    document.getElementById('foto').focus();
}

function fecharModalFoto() {
    document.getElementById('modalFoto').style.display = 'none';
    document.body.style.overflow = 'auto';
    // Limpar formulário
    document.getElementById('formFoto').reset();
}

function confirmarExclusaoFoto(id, nome) {
    document.getElementById('nomeFotoExclusao').textContent = nome;
    document.getElementById('formExclusaoFoto').action = `/professor/config/fotos/${id}`;
    document.getElementById('modalExclusaoFoto').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function fecharModalExclusaoFoto() {
    document.getElementById('modalExclusaoFoto').style.display = 'none';
    document.body.style.overflow = 'auto';
}
</script>
@endsection
