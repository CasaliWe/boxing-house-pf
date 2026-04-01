<div class="space-y-6">
    <div>
        <label for="nome" class="block text-sm font-medium text-gray-300 mb-2">Nome do Exercício</label>
        <input type="text" id="nome" name="nome" value="{{ old('nome', $ideia->nome ?? '') }}" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ex.: Sombra com deslocamento">
        @error('nome')
            <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="descricao" class="block text-sm font-medium text-gray-300 mb-2">Descrição</label>
        <textarea id="descricao" name="descricao" rows="5" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Descreva o exercício, como executar, séries, etc.">{{ old('descricao', $ideia->descricao ?? '') }}</textarea>
        @error('descricao')
            <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="video" class="block text-sm font-medium text-gray-300 mb-2">Vídeo (opcional)</label>
        @if(isset($ideia) && $ideia->video_path)
            <div class="mb-3">
                <video controls class="w-full max-w-md rounded-lg border border-gray-600">
                    <source src="{{ asset($ideia->video_path) }}" type="video/mp4">
                    Seu navegador não suporta vídeo.
                </video>
                <p class="text-gray-400 text-sm mt-1">Envie um novo vídeo para substituir o atual.</p>
            </div>
        @endif
        <input type="file" id="video" name="video" accept="video/*" class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-600 file:text-white file:cursor-pointer">
        @error('video')
            <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
        @enderror
    </div>

    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('professor.ideias-exercicios.index') }}" class="px-4 py-2 rounded-md border border-gray-600 text-gray-200 hover:bg-gray-700">Cancelar</a>
        <button id="btnSalvarIdeia" type="submit" class="px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white">
            <span class="btn-spin inline-block align-middle w-4 h-4 border-2 border-white/60 border-t-transparent rounded-full animate-spin mr-2" style="display:none"></span>
            <span class="btn-text">{{ isset($ideia) ? 'Atualizar' : 'Salvar' }}</span>
        </button>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function(){
        const btn = document.getElementById('btnSalvarIdeia');
        let form = btn;
        while(form && form.tagName !== 'FORM'){ form = form.parentElement; }
        if(form && btn){
            form.addEventListener('submit', function(){
                btn.disabled = true;
                btn.classList.add('opacity-70','cursor-not-allowed');
                const txt = btn.querySelector('.btn-text');
                const spn = btn.querySelector('.btn-spin');
                if(txt) txt.textContent = '{{ isset($ideia) ? 'Atualizando...' : 'Salvando...' }}';
                if(spn) spn.style.display = 'inline-block';
            }, { once: true });
        }
    });
    </script>
</div>
