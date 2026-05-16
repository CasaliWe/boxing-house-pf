@extends('layouts.landing')

@section('title', 'Agendar Aula Experimental - Boxing House PF')
@section('description', 'Agende sua aula experimental na Boxing House PF. Venha conhecer nosso espaço e treinar com a gente!')

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
                <h1 class="text-3xl md:text-4xl font-bold text-blue-400 mb-4">🥊 Agendar Aula Experimental</h1>
                <p class="text-lg text-gray-300">
                    Preencha o formulário abaixo e agende sua aula experimental. Venha conhecer a Boxing House PF!
                </p>
                @if($valorExperimental)
                    <div class="mt-4 inline-flex items-center justify-center px-4 py-2 rounded-lg border border-blue-600 bg-blue-950/40 text-blue-100">
                        Aula experimental: <strong class="ml-2">R$ {{ number_format($valorExperimental->valor_aula, 2, ',', '.') }}</strong>
                    </div>
                @endif
            </div>

            <!-- Mensagem de sucesso -->
            @if(session('success'))
                <div class="bg-green-600/20 border border-green-600 text-green-300 rounded-xl p-6 mb-8 text-center" data-aos="fade-up">
                    <svg class="w-12 h-12 mx-auto mb-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <p class="text-lg font-semibold">{{ session('success') }}</p>
                    <p class="text-gray-400 mt-2">Entraremos em contato para confirmar sua aula.</p>
                </div>
            @else
                <form method="POST" action="{{ route('agendar.exp.store') }}" class="space-y-8" data-aos="fade-up">
                    @csrf

                    <!-- Dados Pessoais -->
                    <div class="bg-gray-900 border border-gray-600 rounded-xl p-6">
                        <h2 class="text-xl font-bold text-blue-400 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Seus Dados
                        </h2>

                        <div class="space-y-6">
                            <!-- Nome -->
                            <div>
                                <label for="nome" class="block text-sm font-medium text-gray-300 mb-2">Seu Nome *</label>
                                <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required
                                       class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="Digite seu nome completo">
                                @error('nome')
                                    <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Telefone -->
                            <div>
                                <label for="numero" class="block text-sm font-medium text-gray-300 mb-2">WhatsApp / Telefone (opcional)</label>
                                <input type="text" id="numero" name="numero" value="{{ old('numero') }}"
                                       class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="(54) 9 9999-9999">
                                @error('numero')
                                    <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Seleção de Horário -->
                    <div class="bg-gray-900 border border-gray-600 rounded-xl p-6">
                        <h2 class="text-xl font-bold text-blue-400 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Selecione o Horário *
                        </h2>
                        <p class="text-gray-400 text-sm mb-4">Escolha um horário disponível para sua aula experimental. Horários lotados estão indisponíveis.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($horarios as $h)
                                @php
                                    $temVaga = $h->vagas_disponiveis > 0;
                                @endphp
                                <label class="border border-gray-600 rounded-lg p-4 bg-gray-800/40 flex items-center gap-3 {{ $temVaga ? 'cursor-pointer hover:border-blue-500' : 'cursor-not-allowed opacity-70' }}">
                                    <input type="radio" name="horario_id" value="{{ $h->id }}"
                                           {{ old('horario_id') == $h->id ? 'checked' : '' }}
                                           {{ $temVaga ? '' : 'disabled' }}
                                           class="text-blue-500">
                                    <div>
                                        <div class="text-white font-semibold flex items-center gap-2">
                                            <span>{{ $h->dia_semana_label }}</span>
                                            <span class="text-xs px-2 py-0.5 rounded {{ $temVaga ? 'bg-green-700 text-white' : 'bg-red-700 text-white' }}">
                                                {{ $temVaga ? ($h->vagas_disponiveis.'/'.$h->limite_alunos.' vaga(s)') : 'FULL' }}
                                            </span>
                                        </div>
                                        <div class="text-gray-300">{{ \Illuminate\Support\Carbon::parse($h->hora_inicio)->format('H:i') }} - {{ \Illuminate\Support\Carbon::parse($h->hora_fim)->format('H:i') }}</div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('horario_id')
                            <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Observação -->
                    <div class="bg-gray-900 border border-gray-600 rounded-xl p-6">
                        <h2 class="text-xl font-bold text-blue-400 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Observação (opcional)
                        </h2>

                        <textarea id="observacao" name="observacao" rows="3"
                                  class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="Alguma observação, dúvida ou informação adicional...">{{ old('observacao') }}</textarea>
                        @error('observacao')
                            <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Botão Enviar -->
                    <div class="text-center">
                        <button type="submit" id="btnAgendar"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg text-lg font-semibold transition-colors inline-flex items-center gap-2">
                            <span class="btn-spin inline-block align-middle w-5 h-5 border-2 border-white/60 border-t-transparent rounded-full animate-spin" style="display:none"></span>
                            <span class="btn-text">Agendar Aula Experimental</span>
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
    // Loading no botão ao enviar
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function() {
                const btn = document.getElementById('btnAgendar');
                if (btn) {
                    btn.disabled = true;
                    btn.classList.add('opacity-70', 'cursor-not-allowed');
                    const txt = btn.querySelector('.btn-text');
                    const spn = btn.querySelector('.btn-spin');
                    if (txt) txt.textContent = 'Agendando...';
                    if (spn) spn.style.display = 'inline-block';
                }
            });
        }
    });
</script>
@endsection
