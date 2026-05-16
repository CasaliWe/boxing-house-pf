<div class="p-6 space-y-5">
    <div>
        <label for="nome" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Nome do exercício</label>
        <input type="text" id="nome" name="nome" value="{{ old('nome', $ideia->nome ?? '') }}" placeholder="Ex.: Sombra com deslocamento"
               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        @error('nome')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
    </div>

    <div>
        <label for="descricao" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Descrição</label>
        <textarea id="descricao" name="descricao" rows="5" placeholder="Descreva o exercício, como executar, séries, etc."
                  class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none">{{ old('descricao', $ideia->descricao ?? '') }}</textarea>
        @error('descricao')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
    </div>

    <div>
        <label for="video" class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Vídeo <span class="text-gray-500 normal-case font-normal">(opcional)</span></label>
        @if(isset($ideia) && $ideia->video_path)
            <div class="mb-3">
                <div class="text-xs text-gray-500 uppercase tracking-wider mb-1.5">Vídeo atual</div>
                <video controls class="w-full max-w-md rounded-md border border-gray-700">
                    <source src="{{ asset($ideia->video_path) }}" type="video/mp4">
                </video>
                <p class="text-xs text-gray-500 mt-1.5">Envie um novo vídeo para substituir o atual.</p>
            </div>
        @endif
        <input type="file" id="video" name="video" accept="video/*"
               class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent file:mr-3 file:border-0 file:bg-blue-600 file:text-white file:rounded file:px-3 file:py-1 file:text-xs file:font-medium hover:file:bg-blue-700">
        @error('video')<div class="text-xs text-red-400 mt-1.5">{{ $message }}</div>@enderror
    </div>
</div>

<div class="flex items-center justify-end gap-2 px-6 py-4 border-t border-gray-800">
    <a href="{{ route('professor.ideias-exercicios.index') }}"
       class="text-sm font-medium px-4 py-2 rounded-md border border-gray-700 text-gray-300 hover:bg-gray-800 transition-colors">
        Cancelar
    </a>
    <button id="btnSalvarIdeia" type="submit"
            style="background-color: #2563eb; color: #ffffff;"
            onmouseover="this.style.backgroundColor='#1d4ed8'"
            onmouseout="this.style.backgroundColor='#2563eb'"
            class="inline-flex items-center text-sm font-medium px-4 py-2 rounded-md transition-colors">
        <span class="btn-spin inline-block align-middle w-3.5 h-3.5 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
        <span class="btn-text">{{ isset($ideia) ? 'Atualizar' : 'Salvar' }}</span>
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        const btn = document.getElementById('btnSalvarIdeia');
        let form  = btn;
        while (form && form.tagName !== 'FORM') { form = form.parentElement; }
        if (form && btn) {
            form.addEventListener('submit', function(){
                btn.disabled = true;
                btn.classList.add('opacity-70','cursor-not-allowed');
                const txt = btn.querySelector('.btn-text');
                const spn = btn.querySelector('.btn-spin');
                if (txt) txt.textContent = '{{ isset($ideia) ? 'Atualizando...' : 'Salvando...' }}';
                if (spn) spn.style.display = 'inline-block';
            }, { once: true });
        }
    });
</script>
