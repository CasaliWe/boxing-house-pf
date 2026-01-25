@extends('layouts.app')

@section('title', 'App - Sistema do Aluno')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold text-blue-400">📱 App - Sistema do Aluno</h1>
        <p class="text-gray-400">Configure as informações que aparecerão na seção Sistema do Aluno da landing page.</p>
    </div>

    <form method="POST" action="{{ route('professor.app.update') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Informações Básicas -->
        <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
            <h2 class="text-xl font-bold text-blue-400 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Informações Básicas
            </h2>

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="titulo" class="block text-sm font-medium text-gray-300 mb-2">Título da Seção *</label>
                    <input type="text" id="titulo" name="titulo" value="{{ old('titulo', $sistemaAluno->titulo) }}" 
                           class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           placeholder="Ex.: Sistema do Aluno" required>
                    @error('titulo')
                        <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="descricao" class="block text-sm font-medium text-gray-300 mb-2">Descrição (opcional)</label>
                    <textarea id="descricao" name="descricao" rows="2" 
                              class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" 
                              placeholder="Descrição que aparece abaixo do título...">{{ old('descricao', $sistemaAluno->descricao) }}</textarea>
                    @error('descricao')
                        <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="detalhes" class="block text-sm font-medium text-gray-300 mb-2">Detalhes *</label>
                    <textarea id="detalhes" name="detalhes" rows="4" 
                              class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" 
                              placeholder="Texto explicativo sobre o sistema..." required>{{ old('detalhes', $sistemaAluno->detalhes) }}</textarea>
                    @error('detalhes')
                        <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                    @enderror
                    <p class="text-xs text-gray-400 mt-2">Máximo de 1000 caracteres.</p>
                </div>
            </div>
        </div>

        <!-- Itens do Resumo -->
        <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
            <h2 class="text-xl font-bold text-blue-400 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Itens do Resumo
            </h2>

            <div id="resumo-items-container">
                @php
                    $resumoItems = old('resumo_items', $sistemaAluno->resumo_items ?? []);
                @endphp
                
                @if(empty($resumoItems))
                    <div class="resumo-item grid grid-cols-1 md:grid-cols-12 gap-3 mb-3">
                        <div class="md:col-span-11">
                            <input type="text" name="resumo_items[]" 
                                   class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                   placeholder="Ex.: Evolução real no seu ritmo" required>
                        </div>
                        <div class="md:col-span-1 flex items-center">
                            <button type="button" onclick="removerItem(this)" 
                                    class="w-full bg-red-600 hover:bg-red-700 text-white p-3 rounded-lg transition-colors">
                                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @else
                    @foreach($resumoItems as $indice => $item)
                        <div class="resumo-item grid grid-cols-1 md:grid-cols-12 gap-3 mb-3">
                            <div class="md:col-span-11">
                                <input type="text" name="resumo_items[]" value="{{ $item }}"
                                       class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                       placeholder="Ex.: Evolução real no seu ritmo" required>
                            </div>
                            <div class="md:col-span-1 flex items-center">
                                <button type="button" onclick="removerItem(this)" 
                                        class="w-full bg-red-600 hover:bg-red-700 text-white p-3 rounded-lg transition-colors">
                                    <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <button type="button" onclick="adicionarItem()" 
                    class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Adicionar Item
            </button>

            @error('resumo_items')
                <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
            @enderror
            @error('resumo_items.*')
                <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Imagens do Sistema -->
        <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
            <h2 class="text-xl font-bold text-blue-400 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Imagens (máximo 10)
            </h2>

            <!-- Imagens Atuais -->
            @php
                $imagensAtuais = $sistemaAluno->imagens ?? [];
            @endphp

            @if(!empty($imagensAtuais))
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-300 mb-4">Imagens Atuais</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($imagensAtuais as $indice => $imagem)
                            <div class="relative group">
                                <img src="{{ asset($imagem) }}" alt="Imagem do Sistema {{ $indice + 1 }}" 
                                     class="w-full h-48 object-cover rounded-lg">
                                <div class="absolute inset-0 bg-black bg-opacity-50 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center">
                                    <button type="button" 
                                            onclick="removerImagem({{ $indice }})"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg text-sm transition-colors">
                                        <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Remover
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Upload de Novas Imagens -->
            @if(count($imagensAtuais) < 10)
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Adicionar Novas Imagens ({{ 10 - count($imagensAtuais) }} restantes)
                    </label>
                    <div class="border-2 border-dashed border-gray-600 rounded-lg p-6 text-center hover:border-blue-500 transition-colors">
                        <input type="file" name="novas_imagens[]" id="novas_imagens" multiple 
                               accept="image/*" 
                               class="hidden" 
                               onchange="previewImages(this)"
                               max="{{ 10 - count($imagensAtuais) }}">
                        <label for="novas_imagens" class="cursor-pointer">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <p class="text-gray-400">Clique para selecionar imagens</p>
                            <p class="text-xs text-gray-500 mt-1">Máximo 5MB por imagem</p>
                        </label>
                    </div>
                    @error('novas_imagens.*')
                        <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Preview das novas imagens -->
                <div id="preview-container" class="mt-4 hidden">
                    <h4 class="text-sm font-medium text-gray-300 mb-2">Preview das Novas Imagens:</h4>
                    <div id="preview-images" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                </div>
            @else
                <div class="bg-yellow-900/50 border border-yellow-500 rounded-lg p-4">
                    <p class="text-yellow-400">Você já atingiu o limite máximo de 10 imagens. Remova uma imagem existente para adicionar uma nova.</p>
                </div>
            @endif
        </div>

        <!-- Botões -->
        <div class="flex flex-col sm:flex-row justify-end gap-3">
            <button type="button" onclick="history.back()" 
                    class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-colors">
                Cancelar
            </button>
            <button type="submit" id="btnSalvarSistema"
                    class="px-6 py-3 bg-gradient-blue hover:from-blue-700 hover:to-purple-700 text-white rounded-lg transition-all duration-300 flex items-center justify-center">
                <span class="btn-spin inline-block align-middle w-4 h-4 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="btn-text">Salvar Configurações</span>
            </button>
        </div>
    </form>
</div>

<!-- Scripts -->
<script>
// Adicionar item do resumo
function adicionarItem() {
    const container = document.getElementById('resumo-items-container');
    const novoItem = document.createElement('div');
    novoItem.className = 'resumo-item grid grid-cols-1 md:grid-cols-12 gap-3 mb-3';
    novoItem.innerHTML = `
        <div class="md:col-span-11">
            <input type="text" name="resumo_items[]" 
                   class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" 
                   placeholder="Ex.: Evolução real no seu ritmo" required>
        </div>
        <div class="md:col-span-1 flex items-center">
            <button type="button" onclick="removerItem(this)" 
                    class="w-full bg-red-600 hover:bg-red-700 text-white p-3 rounded-lg transition-colors">
                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        </div>
    `;
    container.appendChild(novoItem);
}

// Remover item do resumo
function removerItem(button) {
    const items = document.querySelectorAll('.resumo-item');
    if (items.length > 1) {
        button.closest('.resumo-item').remove();
    } else {
        alert('Deve haver pelo menos um item do resumo.');
    }
}

// Preview de imagens
function previewImages(input) {
    const previewContainer = document.getElementById('preview-container');
    const previewImages = document.getElementById('preview-images');
    
    if (input.files.length > 0) {
        previewContainer.classList.remove('hidden');
        previewImages.innerHTML = '';
        
        Array.from(input.files).forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative';
                    div.innerHTML = `
                        <img src="${e.target.result}" alt="Preview ${index + 1}" class="w-full h-32 object-cover rounded-lg">
                        <div class="absolute top-1 right-1 bg-black bg-opacity-50 rounded-full p-1">
                            <span class="text-white text-xs">${index + 1}</span>
                        </div>
                    `;
                    previewImages.appendChild(div);
                };
                reader.readAsDataURL(file);
            }
        });
    } else {
        previewContainer.classList.add('hidden');
    }
}

// Remover imagem existente
async function removerImagem(indice) {
    if (confirm('Tem certeza que deseja remover esta imagem?')) {
        try {
            const response = await fetch('{{ route("professor.app.remover-imagem") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ indice: indice })
            });
            
            const result = await response.json();
            
            if (result.success) {
                location.reload(); // Recarrega a página para mostrar a atualização
            } else {
                alert('Erro ao remover imagem: ' + result.message);
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao remover imagem.');
        }
    }
}

// Loading ao salvar
document.addEventListener('DOMContentLoaded', function(){
    const btn = document.getElementById('btnSalvarSistema');
    let form = btn;
    while(form && form.tagName !== 'FORM'){ form = form.parentElement; }
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