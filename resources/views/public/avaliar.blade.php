@extends('layouts.landing')

@section('title', 'Avaliar - Boxing House PF')
@section('description', 'Avalie sua experiência na Boxing House PF. Sua opinião é muito importante para nós!')

@section('content')

    <!-- Header simples -->
    <header class="fixed w-full top-0 z-50 bg-gray-900/95 backdrop-blur-sm border-b border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('logo-x.png') }}" alt="Boxing House PF" class="h-10 w-auto">
                    </a>
                </div>
                <div class="flex items-center gap-2 md:gap-4">
                    <a href="{{ route('home') }}" class="text-gray-300 hover:text-blue-400 transition-colors text-sm md:text-base">
                        ← Voltar ao site
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Conteúdo -->
    <section class="pt-32 pb-20 bg-gradient-section min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10" data-aos="fade-up">
                <h1 class="text-3xl md:text-4xl font-bold text-blue-400 mb-4">⭐ Avaliar a Boxing House PF</h1>
                <p class="text-lg text-gray-300">
                    Conte sua experiência! Sua avaliação pode ajudar outras pessoas a conhecerem nosso trabalho.
                </p>
            </div>

            <!-- Mensagem de sucesso -->
            @if(session('success'))
                <div class="bg-green-600/20 border border-green-600 text-green-300 rounded-xl p-6 mb-8 text-center" data-aos="fade-up">
                    <svg class="w-12 h-12 mx-auto mb-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <p class="text-lg font-semibold">{{ session('success') }}</p>
                </div>
            @else
                <form method="POST" action="{{ route('avaliar.publica.store') }}" enctype="multipart/form-data" class="space-y-8" data-aos="fade-up">
                    @csrf

                    <!-- Dados da Avaliação -->
                    <div class="bg-gray-900 border border-gray-600 rounded-xl p-6">
                        <h2 class="text-xl font-bold text-blue-400 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            Sua Experiência
                        </h2>

                        <div class="space-y-6">
                            <!-- Nome -->
                            <div>
                                <label for="nome_publico" class="block text-sm font-medium text-gray-300 mb-2">Seu Nome *</label>
                                <input type="text" id="nome_publico" name="nome_publico" value="{{ old('nome_publico') }}" required
                                       class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="Digite seu nome">
                                @error('nome_publico')
                                    <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Comentário -->
                            <div>
                                <label for="comentario" class="block text-sm font-medium text-gray-300 mb-2">Comentário *</label>
                                <textarea id="comentario" name="comentario" rows="5" required
                                          class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                          placeholder="Conte sua experiência na Boxing House PF, como foram os treinos, o ambiente, o que mais gostou...">{{ old('comentario') }}</textarea>
                                @error('comentario')
                                    <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                                @enderror
                                <p class="text-xs text-gray-400 mt-2">Mínimo 10 caracteres, máximo 500 caracteres.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Foto -->
                    <div class="bg-gray-900 border border-gray-600 rounded-xl p-6">
                        <h2 class="text-xl font-bold text-blue-400 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Sua Foto (opcional)
                        </h2>

                        <div class="border-2 border-dashed border-gray-600 rounded-lg p-6 text-center hover:border-blue-500 transition-colors">
                            <input type="file" name="foto_avaliacao" id="foto_avaliacao" accept="image/*" class="hidden" onchange="previewFoto(this)">
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

                        <!-- Preview -->
                        <div id="preview-container" class="mt-4 hidden">
                            <h4 class="text-sm font-medium text-gray-300 mb-2">Preview:</h4>
                            <img id="preview-img" src="" alt="Preview" class="w-24 h-24 object-cover rounded-full border-2 border-blue-400">
                        </div>
                    </div>

                    <!-- Botão Enviar -->
                    <div class="text-center">
                        <button type="submit" id="btnEnviar"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg text-lg font-semibold transition-colors inline-flex items-center gap-2">
                            <span class="btn-spin inline-block align-middle w-5 h-5 border-2 border-white/60 border-t-transparent rounded-full animate-spin" style="display:none"></span>
                            <span class="btn-text">Enviar Avaliação</span>
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 border-t border-gray-700 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex justify-center mb-4">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('logo-y.png') }}" alt="Boxing House PF" class="h-16 w-auto">
                </a>
            </div>
            <p class="text-gray-400 mb-4">Studio de Boxe</p>
            <p class="text-gray-500 text-sm">© {{ date('Y') }} Boxing House PF. Todos os direitos reservados.</p>
        </div>
    </footer>
@endsection

@section('scripts')
<script>
    // Preview da foto
    function previewFoto(input) {
        const container = document.getElementById('preview-container');
        const img = document.getElementById('preview-img');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                container.classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Loading no botão ao enviar
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function() {
                const btn = document.getElementById('btnEnviar');
                if (btn) {
                    btn.disabled = true;
                    btn.classList.add('opacity-70', 'cursor-not-allowed');
                    const txt = btn.querySelector('.btn-text');
                    const spn = btn.querySelector('.btn-spin');
                    if (txt) txt.textContent = 'Enviando...';
                    if (spn) spn.style.display = 'inline-block';
                }
            });
        }
    });
</script>
@endsection
