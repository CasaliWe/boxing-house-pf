@extends('layouts.app')

@section('title', 'App - Sistema do Aluno')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Cabeçalho da página --}}
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Sistema do Aluno</h1>
            <p class="text-sm text-gray-400 mt-1">Conteúdo exibido na seção "Sistema do Aluno" da landing</p>
        </div>
    </div>

    <form method="POST" action="{{ route('professor.app.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Card: informações básicas --}}
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
                <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-white">Informações básicas</h3>
                    <p class="text-xs text-gray-400">Título e descrição da seção</p>
                </div>
            </div>

            <div class="p-6 space-y-5">
                <div>
                    <label for="titulo" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Título da seção *</label>
                    <input type="text" id="titulo" name="titulo" value="{{ old('titulo', $sistemaAluno->titulo) }}" required placeholder="Ex.: Sistema do aluno"
                           class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('titulo')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label for="descricao" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Descrição <span class="text-gray-500 normal-case font-normal">(opcional)</span></label>
                    <textarea id="descricao" name="descricao" rows="2" placeholder="Aparece abaixo do título..."
                              class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none">{{ old('descricao', $sistemaAluno->descricao) }}</textarea>
                    @error('descricao')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label for="detalhes" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Detalhes *</label>
                    <textarea id="detalhes" name="detalhes" rows="4" required placeholder="Texto explicativo sobre o sistema..."
                              class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none">{{ old('detalhes', $sistemaAluno->detalhes) }}</textarea>
                    @error('detalhes')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
                    <p class="text-xs text-gray-500 mt-1.5">Máximo de 1000 caracteres.</p>
                </div>
            </div>
        </div>

        {{-- Card: itens do resumo --}}
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
                <div class="w-9 h-9 rounded-md bg-green-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-white">Itens do resumo</h3>
                    <p class="text-xs text-gray-400">Lista de benefícios exibidos na seção</p>
                </div>
            </div>

            <div class="p-6">
                @php $resumoItems = old('resumo_items', $sistemaAluno->resumo_items ?? []); @endphp

                <div id="resumo-items-container" class="space-y-2">
                    @if(empty($resumoItems))
                        <div class="resumo-item flex gap-2">
                            <input type="text" name="resumo_items[]" required placeholder="Ex.: Evolução real no seu ritmo"
                                   class="flex-1 bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <button type="button" onclick="removerItem(this)"
                                    style="background-color: #dc2626; color: #ffffff;"
                                    onmouseover="this.style.backgroundColor='#b91c1c'"
                                    onmouseout="this.style.backgroundColor='#dc2626'"
                                    class="text-xs font-medium px-3 py-2 rounded-md transition-colors shrink-0">
                                Remover
                            </button>
                        </div>
                    @else
                        @foreach($resumoItems as $indice => $item)
                            <div class="resumo-item flex gap-2">
                                <input type="text" name="resumo_items[]" value="{{ $item }}" required placeholder="Ex.: Evolução real no seu ritmo"
                                       class="flex-1 bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <button type="button" onclick="removerItem(this)"
                                        style="background-color: #dc2626; color: #ffffff;"
                                        onmouseover="this.style.backgroundColor='#b91c1c'"
                                        onmouseout="this.style.backgroundColor='#dc2626'"
                                        class="text-xs font-medium px-3 py-2 rounded-md transition-colors shrink-0">
                                    Remover
                                </button>
                            </div>
                        @endforeach
                    @endif
                </div>

                <button type="button" onclick="adicionarItem()"
                        style="background-color: #2563eb; color: #ffffff;"
                        onmouseover="this.style.backgroundColor='#1d4ed8'"
                        onmouseout="this.style.backgroundColor='#2563eb'"
                        class="mt-3 inline-flex items-center gap-2 text-xs font-medium px-3 py-1.5 rounded-md transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Adicionar item
                </button>

                @error('resumo_items')<div class="text-xs text-red-400 mt-2">{{ $message }}</div>@enderror
                @error('resumo_items.*')<div class="text-xs text-red-400 mt-2">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- Card: imagens --}}
        @php $imagensAtuais = $sistemaAluno->imagens ?? []; @endphp
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
                <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-white">Imagens do sistema</h3>
                    <p class="text-xs text-gray-400">Capturas de tela do app · {{ count($imagensAtuais) }}/10</p>
                </div>
            </div>

            <div class="p-6 space-y-5">
                @if(!empty($imagensAtuais))
                    <div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-2">Imagens atuais</div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                            @foreach($imagensAtuais as $indice => $imagem)
                                <div class="relative group bg-gray-800/40 border border-gray-700 rounded-lg overflow-hidden">
                                    <img src="{{ asset($imagem) }}" alt="Imagem {{ $indice + 1 }}" class="w-full h-44 object-cover">
                                    <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <button type="button" onclick="removerImagem({{ $indice }})"
                                                style="background-color: #dc2626; color: #ffffff;"
                                                onmouseover="this.style.backgroundColor='#b91c1c'"
                                                onmouseout="this.style.backgroundColor='#dc2626'"
                                                class="text-xs font-medium px-3 py-1.5 rounded-md transition-colors">
                                            Remover
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if(count($imagensAtuais) < 10)
                    <div>
                        <label for="novas_imagens" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">
                            Adicionar imagens <span class="text-gray-500 normal-case font-normal">({{ 10 - count($imagensAtuais) }} restantes)</span>
                        </label>
                        <label for="novas_imagens" class="block border-2 border-dashed border-gray-700 hover:border-blue-500/60 rounded-lg p-6 text-center cursor-pointer transition-colors">
                            <input type="file" name="novas_imagens[]" id="novas_imagens" multiple accept="image/*" class="hidden" onchange="previewImages(this)" max="{{ 10 - count($imagensAtuais) }}">
                            <svg class="w-10 h-10 text-gray-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            <p class="text-sm text-gray-400">Clique para selecionar imagens</p>
                            <p class="text-xs text-gray-500 mt-1">Máximo 5MB por imagem</p>
                        </label>
                        @error('novas_imagens.*')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror

                        <div id="preview-container" class="mt-4 hidden">
                            <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-2">Pré-visualização</div>
                            <div id="preview-images" class="grid grid-cols-2 md:grid-cols-4 gap-3"></div>
                        </div>
                    </div>
                @else
                    <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-md px-4 py-3 text-xs text-yellow-200">
                        Limite máximo de 10 imagens atingido.
                    </div>
                @endif
            </div>
        </div>

        {{-- Ações --}}
        <div class="flex justify-end gap-2">
            <button type="button" onclick="history.back()"
                    class="text-sm font-medium px-4 py-2 rounded-md border border-gray-700 text-gray-300 hover:bg-gray-800 transition-colors">
                Cancelar
            </button>
            <button type="submit" id="btnSalvarSistema"
                    style="background-color: #2563eb; color: #ffffff;"
                    onmouseover="this.style.backgroundColor='#1d4ed8'"
                    onmouseout="this.style.backgroundColor='#2563eb'"
                    class="inline-flex items-center text-sm font-medium px-4 py-2 rounded-md transition-colors">
                <span class="btn-spin inline-block align-middle w-3.5 h-3.5 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
                <span class="btn-text">Salvar configurações</span>
            </button>
        </div>
    </form>
</div>

<script>
    // Adiciona um novo item de resumo dinamicamente
    function adicionarItem() {
        const container = document.getElementById('resumo-items-container');
        const div = document.createElement('div');
        div.className = 'resumo-item flex gap-2';
        div.innerHTML = `
            <input type="text" name="resumo_items[]" required placeholder="Ex.: Evolução real no seu ritmo"
                   class="flex-1 bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <button type="button" onclick="removerItem(this)"
                    style="background-color: #dc2626; color: #ffffff;"
                    onmouseover="this.style.backgroundColor='#b91c1c'"
                    onmouseout="this.style.backgroundColor='#dc2626'"
                    class="text-xs font-medium px-3 py-2 rounded-md transition-colors shrink-0">
                Remover
            </button>`;
        container.appendChild(div);
    }

    // Remove um item de resumo (mantém pelo menos um)
    function removerItem(button) {
        const items = document.querySelectorAll('.resumo-item');
        if (items.length > 1) {
            button.closest('.resumo-item').remove();
        } else {
            alert('Deve haver pelo menos um item do resumo.');
        }
    }

    // Pré-visualização das novas imagens
    function previewImages(input) {
        const previewContainer = document.getElementById('preview-container');
        const previewImages    = document.getElementById('preview-images');
        if (input.files.length > 0) {
            previewContainer.classList.remove('hidden');
            previewImages.innerHTML = '';
            Array.from(input.files).forEach((file, index) => {
                if (!file.type.startsWith('image/')) return;
                const reader = new FileReader();
                reader.onload = (e) => {
                    const div = document.createElement('div');
                    div.className = 'bg-gray-800/40 border border-gray-700 rounded-lg overflow-hidden';
                    div.innerHTML = `<img src="${e.target.result}" alt="Preview ${index + 1}" class="w-full h-32 object-cover">`;
                    previewImages.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        } else {
            previewContainer.classList.add('hidden');
        }
    }

    // Remove uma imagem do servidor via ajax
    async function removerImagem(indice) {
        if (!confirm('Tem certeza que deseja remover esta imagem?')) return;
        try {
            const response = await fetch('{{ route("professor.app.remover-imagem") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ indice })
            });
            const result = await response.json();
            if (result.success) {
                location.reload();
            } else {
                alert('Erro ao remover imagem: ' + result.message);
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao remover imagem.');
        }
    }

    // Loading no botão de salvar
    document.addEventListener('DOMContentLoaded', function(){
        const btn  = document.getElementById('btnSalvarSistema');
        let   form = btn;
        while (form && form.tagName !== 'FORM') { form = form.parentElement; }
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
    });
</script>
@endsection
