@extends('layouts.app')

@section('title', 'Meus Dados - Professor')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Cabeçalho da página --}}
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Meus dados — Professor</h1>
            <p class="text-sm text-gray-400 mt-1">Informações que aparecem na landing page</p>
        </div>
    </div>

    <form method="POST" action="{{ route('professor.professor.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Card: dados pessoais --}}
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
                <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-white">Informações pessoais</h3>
                    <p class="text-xs text-gray-400">Nome, experiência e descrição</p>
                </div>
            </div>

            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <label for="name" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Nome completo *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $professor->name) }}" required placeholder="Ex.: João Silva"
                               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('name')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="anos_boxe" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Anos no boxe *</label>
                            <input type="number" id="anos_boxe" name="anos_boxe" value="{{ old('anos_boxe', $professor->anos_boxe) }}" min="0" max="50" required placeholder="5"
                                   class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('anos_boxe')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label for="anos_instrutor" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Como instrutor *</label>
                            <input type="number" id="anos_instrutor" name="anos_instrutor" value="{{ old('anos_instrutor', $professor->anos_instrutor) }}" min="0" max="50" required placeholder="3"
                                   class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('anos_instrutor')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div>
                    <label for="descricao_professor" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Descrição *</label>
                    <textarea id="descricao_professor" name="descricao_professor" rows="4" required placeholder="Conte sobre sua experiência, especialidades e filosofia de ensino..."
                              class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none">{{ old('descricao_professor', $professor->descricao_professor) }}</textarea>
                    @error('descricao_professor')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
                    <p class="text-xs text-gray-500 mt-1.5">Máximo de 1000 caracteres.</p>
                </div>
            </div>
        </div>

        {{-- Card: fotos --}}
        @php $imagensAtuais = json_decode($professor->imagens_professor ?? '[]', true); @endphp
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
                <div class="w-9 h-9 rounded-md bg-blue-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-white">Fotos do professor</h3>
                    <p class="text-xs text-gray-400">Máximo 5 imagens · {{ count($imagensAtuais) }}/5 atual</p>
                </div>
            </div>

            <div class="p-6 space-y-5">
                @if(!empty($imagensAtuais))
                    <div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-2">Imagens atuais</div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach($imagensAtuais as $indice => $imagem)
                                <div class="relative group bg-gray-800/40 border border-gray-700 rounded-lg overflow-hidden">
                                    <img src="{{ asset($imagem) }}" alt="Foto {{ $indice + 1 }}" class="w-full h-44 object-cover">
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

                @if(count($imagensAtuais) < 5)
                    <div>
                        <label for="novas_imagens" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">
                            Adicionar imagens <span class="text-gray-500 normal-case font-normal">({{ 5 - count($imagensAtuais) }} restantes)</span>
                        </label>
                        <label for="novas_imagens" class="block border-2 border-dashed border-gray-700 hover:border-blue-500/60 rounded-lg p-6 text-center cursor-pointer transition-colors">
                            <input type="file" name="novas_imagens[]" id="novas_imagens" multiple accept="image/*" class="hidden" onchange="previewImages(this)" max="{{ 5 - count($imagensAtuais) }}">
                            <svg class="w-10 h-10 text-gray-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            <p class="text-sm text-gray-400">Clique para selecionar imagens</p>
                            <p class="text-xs text-gray-500 mt-1">Máximo 5MB por imagem</p>
                        </label>
                        @error('novas_imagens.*')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror

                        <div id="preview-container" class="mt-4 hidden">
                            <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-2">Pré-visualização</div>
                            <div id="preview-images" class="grid grid-cols-2 md:grid-cols-3 gap-3"></div>
                        </div>
                    </div>
                @else
                    <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-md px-4 py-3 text-xs text-yellow-200">
                        Limite máximo de 5 imagens atingido. Remova uma para adicionar nova.
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
            <button type="submit" id="btnSalvarProfessor"
                    style="background-color: #2563eb; color: #ffffff;"
                    onmouseover="this.style.backgroundColor='#1d4ed8'"
                    onmouseout="this.style.backgroundColor='#2563eb'"
                    class="inline-flex items-center text-sm font-medium px-4 py-2 rounded-md transition-colors">
                <span class="btn-spin inline-block align-middle w-3.5 h-3.5 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
                <span class="btn-text">Salvar alterações</span>
            </button>
        </div>
    </form>
</div>

<script>
    // Preview de imagens recém selecionadas
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
            const response = await fetch('{{ route("professor.professor.remover-imagem") }}', {
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

    // Loading do botão de salvar
    document.addEventListener('DOMContentLoaded', function(){
        const btn  = document.getElementById('btnSalvarProfessor');
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
