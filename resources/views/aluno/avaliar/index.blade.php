@extends('layouts.app')

@section('title', 'Avaliar - Boxing House PF')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold text-blue-400">⭐ Avaliar</h1>
        <p class="text-gray-400">Conte sua experiência na Boxing House PF. Sua avaliação pode ajudar outras pessoas!</p>
    </div>

    <form method="POST" action="{{ route('aluno.avaliar.store') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <!-- Informações da Avaliação -->
        <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
            <h2 class="text-xl font-bold text-blue-400 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                Sua Experiência
            </h2>

            <div class="space-y-6">
                <div>
                    <label for="comentario" class="block text-sm font-medium text-gray-300 mb-2">Comentário *</label>
                    <textarea id="comentario" name="comentario" rows="5" required
                              class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" 
                              placeholder="Conte sua experiência na Boxing House PF, como foram os treinos, o ambiente, o que mais gostou...">{{ old('comentario', $avaliacao->comentario ?? '') }}</textarea>
                    @error('comentario')
                        <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                    @enderror
                    <p class="text-xs text-gray-400 mt-2">Mínimo 10 caracteres, máximo 500 caracteres. Seja autêntico!</p>
                </div>

                <div class="flex items-center">
                    <input type="hidden" name="exibir_landing" value="0">
                    <input type="checkbox" id="exibir_landing" name="exibir_landing" value="1" 
                           {{ old('exibir_landing', $avaliacao->exibir_landing ?? true) ? 'checked' : '' }}
                           class="mr-3 rounded bg-gray-800 border border-gray-600 text-blue-600 focus:ring-blue-500">
                    <label for="exibir_landing" class="text-gray-300">
                        Autorizo exibir minha avaliação na página inicial do site
                    </label>
                </div>
            </div>
        </div>

        <!-- Foto da Avaliação -->
        <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
            <h2 class="text-xl font-bold text-blue-400 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Sua Foto (opcional)
            </h2>

            <!-- Foto Atual -->
            @if($avaliacao && $avaliacao->foto_avaliacao)
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-300 mb-4">Foto Atual</h3>
                    <div class="relative inline-block">
                        <img src="{{ asset($avaliacao->foto_avaliacao) }}" alt="Sua foto de avaliação" 
                             class="w-32 h-32 object-cover rounded-full border-4 border-blue-400">
                        <button type="button" 
                                onclick="removerFoto()"
                                class="absolute -top-2 -right-2 bg-red-600 hover:bg-red-700 text-white p-1.5 rounded-full transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            <!-- Upload Nova Foto -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    {{ $avaliacao && $avaliacao->foto_avaliacao ? 'Alterar Foto' : 'Adicionar Foto' }}
                </label>
                <div class="border-2 border-dashed border-gray-600 rounded-lg p-6 text-center hover:border-blue-500 transition-colors">
                    <input type="file" name="foto_avaliacao" id="foto_avaliacao" 
                           accept="image/*" 
                           class="hidden" 
                           onchange="previewFoto(this)">
                    <label for="foto_avaliacao" class="cursor-pointer">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <p class="text-gray-400">Clique para selecionar uma foto</p>
                        <p class="text-xs text-gray-500 mt-1">Máximo 5MB • Recomendado: foto do rosto</p>
                    </label>
                </div>
                @error('foto_avaliacao')
                    <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Preview da nova foto -->
            <div id="preview-container" class="mt-4 hidden">
                <h4 class="text-sm font-medium text-gray-300 mb-2">Preview:</h4>
                <div id="preview-foto" class="flex justify-center">
                    <!-- Preview será inserido aqui -->
                </div>
            </div>
        </div>

        <!-- Status da Avaliação -->
        @if($avaliacao)
            <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
                <h2 class="text-xl font-bold text-blue-400 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Status da Avaliação
                </h2>
                
                <div class="flex items-center gap-3">
                    @if($avaliacao->ativo)
                        <div class="bg-green-900/50 border border-green-500 rounded-lg p-4 flex items-center gap-3">
                            <svg class="w-6 h-6 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div>
                                <p class="text-green-400 font-semibold">Aprovada!</p>
                                <p class="text-green-300 text-sm">Sua avaliação está sendo exibida no site.</p>
                            </div>
                        </div>
                    @else
                        <div class="bg-yellow-900/50 border border-yellow-500 rounded-lg p-4 flex items-center gap-3">
                            <svg class="w-6 h-6 text-yellow-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-yellow-400 font-semibold">Aguardando aprovação</p>
                                <p class="text-yellow-300 text-sm">O professor irá revisar sua avaliação em breve.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Botões -->
        <div class="flex flex-col sm:flex-row justify-end gap-3">
            <button type="button" onclick="history.back()" 
                    class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-colors">
                Voltar
            </button>
            <button type="submit" id="btnSalvarAvaliacao"
                    class="px-6 py-3 bg-gradient-blue hover:from-blue-700 hover:to-purple-700 text-white rounded-lg transition-all duration-300 flex items-center justify-center">
                <span class="btn-spin inline-block align-middle w-4 h-4 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="btn-text">{{ $avaliacao ? 'Atualizar Avaliação' : 'Enviar Avaliação' }}</span>
            </button>
        </div>
    </form>
</div>

<!-- Scripts -->
<script>
// Preview da foto
function previewFoto(input) {
    const previewContainer = document.getElementById('preview-container');
    const previewFoto = document.getElementById('preview-foto');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewContainer.classList.remove('hidden');
            previewFoto.innerHTML = `
                <img src="${e.target.result}" alt="Preview" class="w-32 h-32 object-cover rounded-full border-4 border-blue-400">
            `;
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        previewContainer.classList.add('hidden');
    }
}

// Remover foto existente
async function removerFoto() {
    if (confirm('Tem certeza que deseja remover sua foto?')) {
        try {
            const response = await fetch('{{ route("aluno.avaliar.remover-foto") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            const result = await response.json();
            
            if (result.success) {
                location.reload(); // Recarrega a página para mostrar a atualização
            } else {
                alert('Erro ao remover foto: ' + result.message);
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao remover foto.');
        }
    }
}

// Loading ao salvar
document.addEventListener('DOMContentLoaded', function(){
    const btn = document.getElementById('btnSalvarAvaliacao');
    let form = btn;
    while(form && form.tagName !== 'FORM'){ form = form.parentElement; }
    if(form && btn){
        form.addEventListener('submit', function(){
            btn.disabled = true;
            btn.classList.add('opacity-70','cursor-not-allowed');
            const txt = btn.querySelector('.btn-text');
            const spn = btn.querySelector('.btn-spin');
            if(txt) txt.textContent = 'Enviando...';
            if(spn) spn.style.display = 'inline-block';
        }, { once: true });
    }
});
</script>
@endsection