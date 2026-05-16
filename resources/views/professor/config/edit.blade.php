@extends('layouts.app')

@section('title', 'Configurações')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- Cabeçalho da página --}}
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Configurações</h1>
            <p class="text-sm text-gray-400 mt-1">Dados da academia, integração WhatsApp e mídias da landing</p>
        </div>
    </div>

    {{-- Card: dados gerais --}}
    <form method="POST" action="{{ route('professor.config.update') }}">
        @csrf
        @method('PUT')

        <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
                <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-white">Dados da academia</h3>
                    <p class="text-xs text-gray-400">Aparecem no rodapé e em links de contato</p>
                </div>
            </div>

            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="pix" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Chave PIX</label>
                        <input type="text" id="pix" name="pix" value="{{ old('pix', $config->pix) }}" placeholder="Ex.: chave@pix.com ou CPF/CNPJ"
                               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('pix')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="whatsapp" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">WhatsApp da academia</label>
                        <input type="text" id="whatsapp" name="whatsapp" value="{{ old('whatsapp', $config->whatsapp) }}" placeholder="(54) 9 91538488"
                               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('whatsapp')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div>
                    <label for="maps_src" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Google Maps <span class="text-gray-500 normal-case font-normal">(conteúdo do src)</span></label>
                    <input type="text" id="maps_src" name="maps_src" value="{{ old('maps_src', $config->maps_src) }}" placeholder='Cole aqui apenas o conteúdo do src="..." do iframe'
                           class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('maps_src')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
                    <p class="text-xs text-gray-500 mt-1.5">Ao incorporar o Google Maps, copie só o que está dentro de <code class="text-gray-300">src="..."</code>.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">E-mail</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $config->email) }}" placeholder="contato@boxinghousepf.com"
                               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('email')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="instagram" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Instagram</label>
                        <input type="text" id="instagram" name="instagram" value="{{ old('instagram', $config->instagram) }}" placeholder="@boxinghousepf"
                               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('instagram')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="cidade" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Cidade</label>
                        <input type="text" id="cidade" name="cidade" value="{{ old('cidade', $config->cidade) }}" placeholder="Passo Fundo"
                               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="bairro" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Bairro</label>
                        <input type="text" id="bairro" name="bairro" value="{{ old('bairro', $config->bairro) }}" placeholder="Centro"
                               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <label for="rua" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Rua / Avenida</label>
                        <input type="text" id="rua" name="rua" value="{{ old('rua', $config->rua) }}" placeholder="Rua Teixeira Soares"
                               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="numero" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Número</label>
                        <input type="text" id="numero" name="numero" value="{{ old('numero', $config->numero) }}" placeholder="123"
                               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: API WhatsApp --}}
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden mt-6">
            <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
                <div class="w-9 h-9 rounded-md bg-green-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-white">API WhatsApp (uazapi)</h3>
                    <p class="text-xs text-gray-400">Credenciais para envio automático de mensagens</p>
                </div>
            </div>

            <div class="p-6 space-y-5">
                <div class="bg-blue-500/5 border border-blue-500/30 rounded-md px-4 py-3 text-xs text-blue-200">
                    Se deixados em branco, o sistema utilizará valores padrão.
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="whatsapp_api_url" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">URL da API</label>
                        <input type="url" id="whatsapp_api_url" name="whatsapp_api_url" value="{{ old('whatsapp_api_url', $config->whatsapp_api_url) }}" placeholder="https://api.uazapi.com"
                               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="whatsapp_api_token" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Token</label>
                        <input type="text" id="whatsapp_api_token" name="whatsapp_api_token" value="{{ old('whatsapp_api_token', $config->whatsapp_api_token) }}" placeholder="Token de autorização"
                               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 px-6 py-4 border-t border-gray-800">
                <button id="btnSalvarConfig" type="submit"
                        style="background-color: #2563eb; color: #ffffff;"
                        onmouseover="this.style.backgroundColor='#1d4ed8'"
                        onmouseout="this.style.backgroundColor='#2563eb'"
                        class="inline-flex items-center text-sm font-medium px-4 py-2 rounded-md transition-colors">
                    <span class="btn-spin inline-block align-middle w-3.5 h-3.5 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
                    <span class="btn-text">Salvar configurações</span>
                </button>
            </div>
        </div>
    </form>

    {{-- Card: vídeo de apresentação --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
            <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-white">Vídeo de apresentação</h3>
                <p class="text-xs text-gray-400">Vídeo vertical (reels) exibido na landing page</p>
            </div>
        </div>

        <div class="p-6">
            @if($config->video_apresentacao)
                <div class="flex flex-col sm:flex-row items-start gap-6">
                    <div class="w-full sm:w-48 shrink-0">
                        <video controls class="w-full rounded-md border border-gray-700" style="max-height: 340px;">
                            <source src="{{ asset($config->video_apresentacao) }}" type="video/mp4">
                        </video>
                    </div>
                    <div class="flex-1 space-y-3">
                        <form method="POST" action="{{ route('professor.config.video.store') }}" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Substituir vídeo</label>
                            <input type="file" name="video_apresentacao" accept="video/*"
                                   class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white file:mr-3 file:border-0 file:bg-blue-600 file:text-white file:rounded file:px-3 file:py-1 file:text-xs file:font-medium hover:file:bg-blue-700">
                            @error('video_apresentacao')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
                            <button type="submit"
                                    style="background-color: #2563eb; color: #ffffff;"
                                    onmouseover="this.style.backgroundColor='#1d4ed8'"
                                    onmouseout="this.style.backgroundColor='#2563eb'"
                                    class="text-xs font-medium px-3 py-1.5 rounded-md transition-colors">
                                Enviar novo vídeo
                            </button>
                        </form>
                        <form method="POST" action="{{ route('professor.config.video.destroy') }}" onsubmit="return confirm('Remover o vídeo de apresentação?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    style="background-color: #dc2626; color: #ffffff;"
                                    onmouseover="this.style.backgroundColor='#b91c1c'"
                                    onmouseout="this.style.backgroundColor='#dc2626'"
                                    class="text-xs font-medium px-3 py-1.5 rounded-md transition-colors">
                                Remover vídeo
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <form method="POST" action="{{ route('professor.config.video.store') }}" enctype="multipart/form-data" class="text-center py-10 border-2 border-dashed border-gray-700 rounded-lg">
                    @csrf
                    <p class="text-sm text-gray-400 mb-3">Envie um vídeo vertical (formato reels) apresentando sua academia.</p>
                    <input type="file" name="video_apresentacao" accept="video/*" required
                           class="mx-auto bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white file:mr-3 file:border-0 file:bg-blue-600 file:text-white file:rounded file:px-3 file:py-1 file:text-xs file:font-medium hover:file:bg-blue-700">
                    @error('video_apresentacao')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
                    <div class="mt-3">
                        <button type="submit"
                                style="background-color: #16a34a; color: #ffffff;"
                                onmouseover="this.style.backgroundColor='#15803d'"
                                onmouseout="this.style.backgroundColor='#16a34a'"
                                class="text-sm font-medium px-4 py-2 rounded-md transition-colors">
                            Enviar vídeo
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    {{-- Card: fotos do centro --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800 flex items-center justify-between flex-wrap gap-3">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-white">Fotos do CT</h3>
                    <p class="text-xs text-gray-400">Aparecem na galeria da landing</p>
                </div>
            </div>
            <button onclick="abrirModalFoto()"
                    style="background-color: #16a34a; color: #ffffff;"
                    onmouseover="this.style.backgroundColor='#15803d'"
                    onmouseout="this.style.backgroundColor='#16a34a'"
                    class="inline-flex items-center gap-2 text-sm font-medium px-3 py-1.5 rounded-md transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Adicionar foto
            </button>
        </div>

        <div class="p-6">
            @if($fotosCentro->isEmpty())
                <div class="text-center py-10 border-2 border-dashed border-gray-700 rounded-lg">
                    <p class="text-sm text-gray-500">Nenhuma foto adicionada.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($fotosCentro as $foto)
                        <div class="bg-gray-800/40 border border-gray-700 rounded-lg overflow-hidden">
                            <div class="aspect-video bg-gray-900 overflow-hidden">
                                <img src="{{ asset($foto->caminho_arquivo) }}" alt="{{ $foto->nome_original }}" class="w-full h-full object-cover">
                            </div>
                            <div class="p-3 flex items-start justify-between gap-3">
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-sm font-medium text-white truncate">{{ $foto->nome_original }}</h4>
                                    @if($foto->descricao)
                                        <p class="text-xs text-gray-400 mt-0.5 truncate">{{ $foto->descricao }}</p>
                                    @endif
                                    <div class="text-xs text-gray-500 mt-0.5">Ordem: {{ $foto->ordem }}</div>
                                </div>
                                <button onclick="confirmarExclusaoFoto({{ $foto->id }}, '{{ addslashes($foto->nome_original) }}')"
                                        style="background-color: #dc2626; color: #ffffff;"
                                        onmouseover="this.style.backgroundColor='#b91c1c'"
                                        onmouseout="this.style.backgroundColor='#dc2626'"
                                        class="text-xs font-medium px-2 py-1 rounded transition-colors shrink-0">
                                    Excluir
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Card: analytics --}}
    <div class="bg-gray-900/60 border border-gray-800 rounded-lg p-6">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-md bg-red-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-white">Analytics</h3>
                    <p class="text-xs text-gray-400">Apaga todos os dados coletados na landing. Esta ação não pode ser desfeita.</p>
                </div>
            </div>
            <button onclick="confirmarResetAnalytics()"
                    style="background-color: #dc2626; color: #ffffff;"
                    onmouseover="this.style.backgroundColor='#b91c1c'"
                    onmouseout="this.style.backgroundColor='#dc2626'"
                    class="text-sm font-medium px-4 py-2 rounded-md transition-colors">
                Resetar analytics
            </button>
        </div>
    </div>
</div>

{{-- Modal: Reset Analytics --}}
<div id="modalResetAnalytics" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 hidden">
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-gray-900 border border-gray-700 rounded-xl shadow-2xl w-full max-w-md">
            <div class="px-6 py-4 border-b border-gray-800">
                <h3 class="text-lg font-semibold text-white">Confirmar reset</h3>
            </div>
            <div class="px-6 py-5">
                <p class="text-sm text-gray-300">Tem certeza que deseja apagar todos os dados de analytics?</p>
                <p class="text-xs text-red-400 mt-2">Esta ação não pode ser desfeita.</p>
            </div>
            <div class="flex justify-end gap-2 px-6 py-4 border-t border-gray-800">
                <button onclick="fecharModalResetAnalytics()" class="text-sm font-medium px-4 py-2 rounded-md border border-gray-700 text-gray-300 hover:bg-gray-800 transition-colors">
                    Cancelar
                </button>
                <form method="POST" action="{{ route('professor.config.analytics.reset') }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            style="background-color: #dc2626; color: #ffffff;"
                            onmouseover="this.style.backgroundColor='#b91c1c'"
                            onmouseout="this.style.backgroundColor='#dc2626'"
                            class="text-sm font-medium px-4 py-2 rounded-md transition-colors">
                        Sim, resetar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal: Adicionar Foto --}}
<div id="modalFoto" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 hidden">
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-gray-900 border border-gray-700 rounded-xl shadow-2xl w-full max-w-md">
            <div class="flex justify-between items-center px-6 py-4 border-b border-gray-800">
                <h3 class="text-lg font-semibold text-white">Adicionar foto</h3>
                <button onclick="fecharModalFoto()" class="text-gray-400 hover:text-white text-xl leading-none">✕</button>
            </div>
            <form id="formFoto" method="POST" action="{{ route('professor.config.fotos.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="px-6 py-5 space-y-4">
                    <div>
                        <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Foto</label>
                        <input type="file" id="foto" name="foto" accept="image/*" required
                               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white file:mr-3 file:border-0 file:bg-blue-600 file:text-white file:rounded file:px-3 file:py-1 file:text-xs file:font-medium hover:file:bg-blue-700">
                        <p class="text-xs text-gray-500 mt-1.5">JPG, PNG ou GIF. Máximo 5MB.</p>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Descrição <span class="text-gray-500 normal-case font-normal">(opcional)</span></label>
                        <input type="text" id="descricao" name="descricao" placeholder="Ex.: Área de treino principal"
                               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
                <div class="flex justify-end gap-2 px-6 py-4 border-t border-gray-800">
                    <button type="button" onclick="fecharModalFoto()" class="text-sm font-medium px-4 py-2 rounded-md border border-gray-700 text-gray-300 hover:bg-gray-800 transition-colors">
                        Cancelar
                    </button>
                    <button id="btnSalvarFoto" type="submit"
                            style="background-color: #16a34a; color: #ffffff;"
                            onmouseover="this.style.backgroundColor='#15803d'"
                            onmouseout="this.style.backgroundColor='#16a34a'"
                            class="text-sm font-medium px-4 py-2 rounded-md transition-colors">
                        <span class="btn-spin inline-block align-middle w-3.5 h-3.5 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
                        <span class="btn-text">Adicionar foto</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal: Excluir Foto --}}
<div id="modalExclusaoFoto" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 hidden">
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-gray-900 border border-gray-700 rounded-xl shadow-2xl w-full max-w-md">
            <div class="px-6 py-4 border-b border-gray-800">
                <h3 class="text-lg font-semibold text-white">Confirmar exclusão</h3>
            </div>
            <div class="px-6 py-5">
                <p class="text-sm text-gray-300">Excluir a foto <span id="nomeFotoExclusao" class="font-semibold text-white"></span>?</p>
                <p class="text-xs text-red-400 mt-2">Esta ação não pode ser desfeita.</p>
            </div>
            <div class="flex justify-end gap-2 px-6 py-4 border-t border-gray-800">
                <button onclick="fecharModalExclusaoFoto()" class="text-sm font-medium px-4 py-2 rounded-md border border-gray-700 text-gray-300 hover:bg-gray-800 transition-colors">
                    Cancelar
                </button>
                <form id="formExclusaoFoto" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            style="background-color: #dc2626; color: #ffffff;"
                            onmouseover="this.style.backgroundColor='#b91c1c'"
                            onmouseout="this.style.backgroundColor='#dc2626'"
                            class="text-sm font-medium px-4 py-2 rounded-md transition-colors">
                        Sim, excluir
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        // Máscara de WhatsApp (XX) X XXXXXXXX
        const onlyDigits = (s) => (s || '').replace(/\D+/g, '');
        function formatWhatsapp(raw) {
            const d    = onlyDigits(raw);
            const dd   = d.slice(0, 2);
            const nine = d.slice(2, 3);
            const rest = d.slice(3, 11);
            let out = '';
            if (dd)   out += '(' + dd + ')';
            if (nine) out += ' ' + nine;
            if (rest) out += ' ' + rest;
            return out.trim();
        }
        const wa = document.getElementById('whatsapp');
        if (wa) {
            wa.addEventListener('input', () => wa.value = formatWhatsapp(wa.value));
            wa.addEventListener('blur',  () => wa.value = formatWhatsapp(wa.value));
        }

        // Loading do botão de configurações
        const btn  = document.getElementById('btnSalvarConfig');
        const form = btn?.closest('form');
        if (form && btn) {
            form.addEventListener('submit', function(){
                btn.disabled = true;
                btn.classList.add('opacity-70','cursor-not-allowed');
                const txt = btn.querySelector('.btn-text');
                const spn = btn.querySelector('.btn-spin');
                if (txt) txt.textContent = 'Salvando...';
                if (spn) spn.style.display = 'inline-block';
            }, { once: true });
        }

        // Loading do botão de foto
        const btnFoto  = document.getElementById('btnSalvarFoto');
        const formFoto = btnFoto?.closest('form');
        if (formFoto && btnFoto) {
            formFoto.addEventListener('submit', function(){
                btnFoto.disabled = true;
                btnFoto.classList.add('opacity-70','cursor-not-allowed');
                const txt = btnFoto.querySelector('.btn-text');
                const spn = btnFoto.querySelector('.btn-spin');
                if (txt) txt.textContent = 'Enviando...';
                if (spn) spn.style.display = 'inline-block';
            }, { once: true });
        }

        // Fechar modais com ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                fecharModalFoto();
                fecharModalExclusaoFoto();
                fecharModalResetAnalytics();
            }
        });
    });

    // Modais de foto
    function abrirModalFoto() {
        document.getElementById('modalFoto').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function fecharModalFoto() {
        document.getElementById('modalFoto').classList.add('hidden');
        document.body.style.overflow = 'auto';
        document.getElementById('formFoto')?.reset();
    }
    function confirmarExclusaoFoto(id, nome) {
        document.getElementById('nomeFotoExclusao').textContent = nome;
        document.getElementById('formExclusaoFoto').action = `/professor/config/fotos/${id}`;
        document.getElementById('modalExclusaoFoto').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function fecharModalExclusaoFoto() {
        document.getElementById('modalExclusaoFoto').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    // Modal de reset analytics
    function confirmarResetAnalytics() {
        document.getElementById('modalResetAnalytics').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function fecharModalResetAnalytics() {
        document.getElementById('modalResetAnalytics').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>
@endsection
