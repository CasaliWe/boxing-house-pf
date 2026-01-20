@extends('layouts.app')

@section('title', 'Meus Dados - Professor')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold text-blue-400">👤 Meus Dados - Professor</h1>
        <p class="text-gray-400">Atualize suas informações pessoais, experiência e imagens de perfil.</p>
    </div>

    <form method="POST" action="{{ route('professor.professor.update') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Dados Básicos -->
        <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
            <h2 class="text-xl font-bold text-blue-400 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Informações Pessoais
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Nome Completo *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $professor->name) }}" 
                           class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           placeholder="Ex.: João Silva" required>
                    @error('name')
                        <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="anos_boxe" class="block text-sm font-medium text-gray-300 mb-2">Anos no Boxe *</label>
                        <input type="number" id="anos_boxe" name="anos_boxe" value="{{ old('anos_boxe', $professor->anos_boxe) }}" 
                               min="0" max="50" 
                               class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" 
                               placeholder="5" required>
                        @error('anos_boxe')
                            <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="anos_instrutor" class="block text-sm font-medium text-gray-300 mb-2">Anos Instrutor *</label>
                        <input type="number" id="anos_instrutor" name="anos_instrutor" value="{{ old('anos_instrutor', $professor->anos_instrutor) }}" 
                               min="0" max="50" 
                               class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" 
                               placeholder="3" required>
                        @error('anos_instrutor')
                            <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <label for="descricao_professor" class="block text-sm font-medium text-gray-300 mb-2">Descrição *</label>
                <textarea id="descricao_professor" name="descricao_professor" rows="4" 
                          class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" 
                          placeholder="Conte um pouco sobre sua experiência, especialidades e filosofia de ensino..." required>{{ old('descricao_professor', $professor->descricao_professor) }}</textarea>
                @error('descricao_professor')
                    <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                @enderror
                <p class="text-xs text-gray-400 mt-2">Máximo de 1000 caracteres. Seja autêntico e conte sua história!</p>
            </div>
        </div>

        <!-- Imagens do Professor -->
        <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
            <h2 class="text-xl font-bold text-blue-400 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Fotos (máximo 5)
            </h2>

            <!-- Imagens Atuais -->
            @php
                $imagensAtuais = json_decode($professor->imagens_professor ?? '[]', true);
            @endphp

            @if(!empty($imagensAtuais))
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-300 mb-4">Imagens Atuais</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($imagensAtuais as $indice => $imagem)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $imagem) }}" alt="Imagem do Professor {{ $indice + 1 }}" 
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
            @if(count($imagensAtuais) < 5)
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Adicionar Novas Imagens ({{ 5 - count($imagensAtuais) }} restantes)
                    </label>
                    <div class="border-2 border-dashed border-gray-600 rounded-lg p-6 text-center hover:border-blue-500 transition-colors">
                        <input type="file" name="novas_imagens[]" id="novas_imagens" multiple 
                               accept="image/*" 
                               class="hidden" 
                               onchange="previewImages(this)"
                               max="{{ 5 - count($imagensAtuais) }}">
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
                    <div id="preview-images" class="grid grid-cols-2 md:grid-cols-3 gap-4"></div>
                </div>
            @else
                <div class="bg-yellow-900/50 border border-yellow-500 rounded-lg p-4">
                    <p class="text-yellow-400">Você já atingiu o limite máximo de 5 imagens. Remova uma imagem existente para adicionar uma nova.</p>
                </div>
            @endif
        </div>

        <!-- Botões -->
        <div class="flex flex-col sm:flex-row justify-end gap-3">
            <button type="button" onclick="history.back()" 
                    class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-colors">
                Cancelar
            </button>
            <button type="submit" id="btnSalvarProfessor"
                    class="px-6 py-3 bg-gradient-blue hover:from-blue-700 hover:to-purple-700 text-white rounded-lg transition-all duration-300 flex items-center justify-center">
                <span class="btn-spin inline-block align-middle w-4 h-4 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="btn-text">Salvar Alterações</span>
            </button>
        </div>
    </form>
</div>

<!-- Scripts para preview e remoção de imagens -->
<script>
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

async function removerImagem(indice) {
    if (confirm('Tem certeza que deseja remover esta imagem?')) {
        try {
            const response = await fetch('{{ route("professor.professor.remover-imagem") }}', {
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

// Loading ao salvar dados do professor
document.addEventListener('DOMContentLoaded', function(){
    const btn = document.getElementById('btnSalvarProfessor');
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