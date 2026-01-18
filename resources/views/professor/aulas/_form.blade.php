@php /** @var \App\Models\AulaSequencia|null $sequencia */ @endphp
<div class="space-y-6">
    <div class="grid grid-cols-1 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Número da aula</label>
            <input type="number" min="1" name="numero" value="{{ old('numero', isset($sequencia) ? $sequencia->numero : '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('numero')<p class="text-red-400 text-sm mt-2">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Descrição da sequência</label>
            <textarea name="descricao" rows="4" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('descricao', isset($sequencia) ? $sequencia->descricao : '') }}</textarea>
            @error('descricao')<p class="text-red-400 text-sm mt-2">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Vídeo da sequência (opcional)</label>
            <input type="file" name="video" accept="video/*" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('video')<p class="text-red-400 text-sm mt-2">{{ $message }}</p>@enderror
            @isset($sequencia)
                @if($sequencia->video_path)
                    <div class="mt-3">
                        <button type="button" class="px-3 py-2 rounded-md border border-gray-600 text-gray-200 hover:bg-gray-700 text-sm"
                                onclick="abrirModalVideo('{{ asset('storage/'.$sequencia->video_path) }}')">Vídeo</button>
                    </div>
                @endif
            @endisset
        </div>
        <div class="flex items-center gap-3">
            <input type="checkbox" name="ativo" value="1" {{ old('ativo', isset($sequencia) ? ($sequencia->ativo ? 'checked' : '') : 'checked') }} class="rounded bg-gray-800 border-gray-600 text-blue-500 focus:ring-blue-500">
            <label class="text-sm text-gray-300">Ativo</label>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <a href="{{ route('professor.aulas-sequencia.index') }}" class="px-4 py-2 rounded-md border border-gray-600 text-gray-200 hover:bg-gray-700 text-center transition duration-150 active:scale-95 focus:outline-none focus:ring-2 focus:ring-gray-500">Cancelar</a>
        <button id="btnSalvarSequencia" type="submit" class="px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white text-center transition duration-150 active:scale-95 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <span class="btn-spin inline-block align-middle w-4 h-4 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
            <span class="btn-text">{{ isset($sequencia) ? 'Atualizar' : 'Salvar' }}</span>
        </button>
    </div>

    <script>
    // Loading ao salvar/atualizar sequência
    document.addEventListener('DOMContentLoaded', function(){
        const btn = document.getElementById('btnSalvarSequencia');
        let form = btn;
        while(form && form.tagName !== 'FORM'){ form = form.parentElement; }
        if(form && btn){
            form.addEventListener('submit', function(){
                btn.disabled = true;
                btn.classList.add('opacity-70','cursor-not-allowed');
                const txt = btn.querySelector('.btn-text');
                const spn = btn.querySelector('.btn-spin');
                if(txt) txt.textContent = '{{ isset($sequencia) ? 'Atualizando...' : 'Salvando...' }}';
                if(spn) spn.style.display = 'inline-block';
            }, { once: true });
        }
    });
    </script>

    <!-- Overlay de vídeo (apenas vídeo, sem fundo visível) -->
    <div id="modalVideoSequencia" class="fixed inset-0 z-50 hidden">
        <div class="w-full h-full flex items-center justify-center" data-close>
            <video id="videoSequencia" controls class="block max-h-[92vh] max-w-[92vw] bg-black rounded" onclick="event.stopPropagation();"></video>
        </div>
    </div>
    <script>
    function abrirModalVideo(src){
        const modal = document.getElementById('modalVideoSequencia');
        const v = document.getElementById('videoSequencia');
        v.src = src;
        modal.classList.remove('hidden');
        modal.addEventListener('click', function(e){ if(e.target.hasAttribute('data-close')){ v.pause(); modal.classList.add('hidden'); } });
    }
    </script>
</div>
