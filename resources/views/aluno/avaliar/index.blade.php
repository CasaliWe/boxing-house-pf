@extends('layouts.app')

@section('title', 'Avaliar - Boxing House PF')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Cabeçalho da página --}}
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Avaliar a academia</h1>
            <p class="text-sm text-gray-400 mt-1">Conte sua experiência na Boxing House PF — pode ajudar outras pessoas</p>
        </div>
    </div>

    {{-- Status da avaliação (se já existe) --}}
    @if($avaliacao)
        <div class="{{ $avaliacao->ativo ? 'bg-green-500/10 border-green-500/40' : 'bg-yellow-500/10 border-yellow-500/40' }} border rounded-lg p-4 flex items-start gap-4">
            <div class="w-10 h-10 rounded-md {{ $avaliacao->ativo ? 'bg-green-500/20' : 'bg-yellow-500/20' }} flex items-center justify-center shrink-0">
                @if($avaliacao->ativo)
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                @else
                    <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                @endif
            </div>
            <div>
                <div class="text-base font-semibold {{ $avaliacao->ativo ? 'text-green-300' : 'text-yellow-300' }}">
                    {{ $avaliacao->ativo ? 'Avaliação aprovada' : 'Aguardando aprovação' }}
                </div>
                <p class="text-sm {{ $avaliacao->ativo ? 'text-green-200/80' : 'text-yellow-200/80' }} mt-0.5">
                    {{ $avaliacao->ativo ? 'Sua avaliação está sendo exibida no site.' : 'O professor irá revisar sua avaliação em breve.' }}
                </p>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('aluno.avaliar.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Card: sua experiência --}}
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
                <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-white">Sua experiência</h3>
                    <p class="text-xs text-gray-400">Conte como foi treinar com a gente</p>
                </div>
            </div>

            <div class="p-6 space-y-5">
                <div>
                    <label for="comentario" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Comentário *</label>
                    <textarea id="comentario" name="comentario" rows="5" required
                              class="w-full bg-gray-800 border border-gray-700 rounded-md p-3 text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                              placeholder="Como foram os treinos, o ambiente, o que mais gostou...">{{ old('comentario', $avaliacao->comentario ?? '') }}</textarea>
                    @error('comentario')
                        <div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1.5">Mínimo 10 e máximo 500 caracteres. Seja autêntico.</p>
                </div>

                <label class="flex items-center gap-2.5 cursor-pointer">
                    <input type="hidden" name="exibir_landing" value="0">
                    <input type="checkbox" id="exibir_landing" name="exibir_landing" value="1"
                           {{ old('exibir_landing', $avaliacao->exibir_landing ?? true) ? 'checked' : '' }}
                           class="rounded bg-gray-800 border-gray-700 text-blue-600 focus:ring-blue-500">
                    <span class="text-sm text-gray-300">Autorizo exibir minha avaliação na página inicial do site</span>
                </label>
            </div>
        </div>

        {{-- Card: foto --}}
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
                <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-white">Sua foto <span class="text-xs text-gray-500 font-normal">(opcional)</span></h3>
                    <p class="text-xs text-gray-400">Aparece junto com seu comentário no site</p>
                </div>
            </div>

            <div class="p-6">
                @if($avaliacao && $avaliacao->foto_avaliacao)
                    <div class="mb-5">
                        <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-2">Foto atual</div>
                        <div class="relative inline-block">
                            <img src="{{ asset($avaliacao->foto_avaliacao) }}" alt="Foto" class="w-28 h-28 object-cover rounded-full border-2 border-blue-500/50">
                            <button type="button" onclick="removerFoto()"
                                    style="background-color: #dc2626; color: #ffffff;"
                                    onmouseover="this.style.backgroundColor='#b91c1c'"
                                    onmouseout="this.style.backgroundColor='#dc2626'"
                                    class="absolute -top-1 -right-1 p-1.5 rounded-full transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif

                <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-2">
                    {{ $avaliacao && $avaliacao->foto_avaliacao ? 'Trocar foto' : 'Adicionar foto' }}
                </label>
                <label for="foto_avaliacao" class="block border-2 border-dashed border-gray-700 hover:border-blue-500/60 rounded-lg p-6 text-center cursor-pointer transition-colors">
                    <input type="file" name="foto_avaliacao" id="foto_avaliacao" accept="image/*" class="hidden" onchange="previewFoto(this)">
                    <svg class="w-10 h-10 text-gray-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <p class="text-sm text-gray-400">Clique para selecionar uma foto</p>
                    <p class="text-xs text-gray-500 mt-1">Máximo 5MB · Recomendado: foto do rosto</p>
                </label>
                @error('foto_avaliacao')
                    <div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>
                @enderror

                <div id="preview-container" class="mt-4 hidden">
                    <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-2">Pré-visualização</div>
                    <div id="preview-foto" class="flex"></div>
                </div>
            </div>
        </div>

        {{-- Ações --}}
        <div class="flex flex-col sm:flex-row justify-end gap-2">
            <button type="button" onclick="history.back()"
                    class="text-sm font-medium px-4 py-2 rounded-md border border-gray-700 text-gray-300 hover:bg-gray-800 transition-colors">
                Voltar
            </button>
            <button type="submit" id="btnSalvarAvaliacao"
                    style="background-color: #2563eb; color: #ffffff;"
                    onmouseover="this.style.backgroundColor='#1d4ed8'"
                    onmouseout="this.style.backgroundColor='#2563eb'"
                    class="inline-flex items-center justify-center text-sm font-medium px-4 py-2 rounded-md transition-colors">
                <span class="btn-spin inline-block align-middle w-3.5 h-3.5 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
                <span class="btn-text">{{ $avaliacao ? 'Atualizar avaliação' : 'Enviar avaliação' }}</span>
            </button>
        </div>
    </form>
</div>

<script>
    // Mostra preview da foto selecionada
    function previewFoto(input) {
        const container = document.getElementById('preview-container');
        const target    = document.getElementById('preview-foto');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                container.classList.remove('hidden');
                target.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-28 h-28 object-cover rounded-full border-2 border-blue-500/50">`;
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            container.classList.add('hidden');
        }
    }

    // Remove a foto atual via ajax
    async function removerFoto() {
        if (!confirm('Tem certeza que deseja remover sua foto?')) return;
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
                location.reload();
            } else {
                alert('Erro ao remover foto: ' + result.message);
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao remover foto.');
        }
    }

    // Loading no botão de salvar
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('btnSalvarAvaliacao');
        let form  = btn;
        while (form && form.tagName !== 'FORM') { form = form.parentElement; }
        if (form && btn) {
            form.addEventListener('submit', function() {
                btn.disabled = true;
                btn.classList.add('opacity-70', 'cursor-not-allowed');
                const txt = btn.querySelector('.btn-text');
                const spn = btn.querySelector('.btn-spin');
                if (txt) txt.textContent = 'Enviando...';
                if (spn) spn.style.display = 'inline-block';
            }, { once: true });
        }
    });
</script>
@endsection
