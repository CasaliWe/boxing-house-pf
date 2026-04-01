@extends('layouts.landing')

@section('title', 'Boxing House PF - Studio de Boxe Personal | Treino Personalizado')
@section('description', 'Studio de boxe feito em casa, espaço compacto e organizado. Atendimento individual ou grupos pequenos, ambiente fechado e sem distrações. Treino personalizado com acompanhamento direto e correção técnica constante. Ideal para iniciantes e praticantes, com foco em condicionamento físico e técnica. Sem lotação, sem treino genérico.')
@section('keywords', 'studio de boxe, treino personalizado, grupos pequenos, foco no aluno, correção técnica, ambiente fechado, condicionamento físico, técnica')

@section('og_title', 'Boxing House PF - Studio de Boxe Personal')
@section('og_description', 'Studio de boxe feito em casa. Atendimento individual ou grupos pequenos, ambiente fechado e sem distrações, treino personalizado com correção técnica constante.')

@section('content')

    <!-- Header/Navegação -->
    <header class="fixed w-full top-0 z-50 bg-gray-900/95 backdrop-blur-sm border-b border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <img src="{{ asset('logo-x.png') }}" alt="Boxing House PF" class="h-10 w-auto">
                </div>
                <nav class="hidden md:flex space-x-8">
                    <a href="#home" class="text-gray-300 hover:text-blue-400 transition-colors">Início</a>
                    <a href="#sobre" class="text-gray-300 hover:text-blue-400 transition-colors">Sobre</a>
                    <a href="#horarios" class="text-gray-300 hover:text-blue-400 transition-colors">Horários</a>
                    <a href="#avaliacoes" class="text-gray-300 hover:text-blue-400 transition-colors">Avaliações</a>
                    <a href="#galeria" class="text-gray-300 hover:text-blue-400 transition-colors">Galeria</a>
                    <a href="#valores" class="text-gray-300 hover:text-blue-400 transition-colors">Valores</a>
                    <a href="#localizacao" class="text-gray-300 hover:text-blue-400 transition-colors">Localização</a>
                    <a href="#contato" class="text-gray-300 hover:text-blue-400 transition-colors">Contato</a>
                </nav>
                <div class="flex items-center gap-2 md:gap-4">
                    @if($config && $config->whatsapp)
                        <a href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}" target="_blank" 
                           class="bg-green-600 hover:bg-green-700 px-3 py-2 md:px-4 md:py-2 rounded-lg text-xs md:text-sm font-medium transition-colors flex items-center gap-1 md:gap-2">
                            <svg class="w-3 h-3 md:w-4 md:h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                            </svg>
                            <span class="hidden sm:inline">WhatsApp</span>
                        </a>
                    @endif
                    <a href="{{ route('login') }}" class="bg-blue-700 hover:bg-blue-800 px-3 py-2 md:px-4 md:py-2 rounded-lg text-xs md:text-sm font-medium transition-colors flex items-center gap-1 md:gap-2">
                        <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="hidden sm:inline">Área Aluno</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="home" class="min-h-screen hero-bg flex items-center relative overflow-hidden">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center">
                <h1 class="mt-20 text-4xl md:text-6xl font-bold mb-6 leading-tight text-white">
                    Studio de Boxe Personal<br>
                    Treino sob medida, sem distrações
                </h1>
                <p class="text-xl md:text-2xl text-blue-100 mb-8 max-w-3xl mx-auto leading-relaxed">
                    Espaço compacto e organizado, ambiente fechado e sem distrações. Atendimento individual ou em grupos pequenos, com acompanhamento direto e correção técnica constante.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center items-center px-4">
                    @if($config && $config->whatsapp)
                        <a href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}?text=Olá! Gostaria de saber mais sobre a Boxing House PF" 
                           target="_blank" 
                           class="bg-green-600 hover:bg-green-700 px-6 sm:px-8 py-3 sm:py-4 rounded-lg text-base sm:text-lg font-semibold transition-colors flex items-center gap-2 sm:gap-3 shadow-lg w-full sm:w-auto justify-center">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                            </svg>
                            Fale Conosco
                        </a>
                    @endif
                    <a href="#sobre" class="border-2 border-white px-6 sm:px-8 py-3 sm:py-4 rounded-lg text-base sm:text-lg font-semibold hover:bg-white hover:text-gray-900 transition-colors flex items-center gap-2 sm:gap-3 w-full sm:w-auto justify-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Saiba Mais
                    </a>
                </div>
            </div>
        </div>
        <!-- Decoração -->
        <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-gray-900 to-transparent"></div>
    </section>

    <!-- Sobre o CT -->
    <section id="sobre" class="py-20 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-400 mb-6">Sobre a Boxing House PF</h2>
                <p class="text-xl text-gray-300 max-w-4xl mx-auto leading-relaxed">
                    Studio de boxe em ambiente privado, compacto e organizado.
                    Atendimento individual ou em grupos reduzidos, garantindo foco total no aluno e correção técnica constante.
                    Treinos personalizados para iniciantes e praticantes, com ênfase em técnica e evolução real.
                    Sem lotação, sem treino genérico, aqui o treino é feito para você.
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-gradient-section border border-gray-600 rounded-xl p-8 text-center hover:scale-105 transition-transform" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-4xl mb-4">🥊</div>
                    <h3 class="text-xl font-semibold text-blue-400 mb-4">Ambiente Fechado</h3>
                    <p class="text-gray-300">
                        Studio em casa, sem distrações, espaço compacto e organizado para treino focado.
                    </p>
                </div>
                
                <div class="bg-gradient-section border border-gray-600 rounded-xl p-8 text-center hover:scale-105 transition-transform" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-4xl mb-4">💪</div>
                    <h3 class="text-xl font-semibold text-blue-400 mb-4">Acompanhamento Direto</h3>
                    <p class="text-gray-300">
                        Correção técnica constante e foco total no aluno, com evolução real no seu ritmo.
                    </p>
                </div>
                
                <div class="bg-gradient-section border border-gray-600 rounded-xl p-8 text-center hover:scale-105 transition-transform" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-4xl mb-4">🎯</div>
                    <h3 class="text-xl font-semibold text-blue-400 mb-4">Treino Personalizado</h3>
                    <p class="text-gray-300">
                        Planejamento sob medida, sem lotação e sem treino genérico. Foco em técnica e evolução real.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefícios -->
    <section id="beneficios" class="py-20 bg-gradient-section">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-400 mb-6">Benefícios Reais</h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Resultados que você vai sentir na prática, além da técnica do boxe.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-gray-900 border border-gray-600 rounded-xl p-6 text-center hover:scale-105 transition-transform" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-4xl mb-4">🔥</div>
                    <h3 class="text-lg font-semibold text-blue-400 mb-3">Mais Condicionamento</h3>
                    <p class="text-gray-300 text-sm">
                        Resistência e força que você sente no dia a dia.
                    </p>
                </div>
                
                <div class="bg-gray-900 border border-gray-600 rounded-xl p-6 text-center hover:scale-105 transition-transform" data-aos="fade-up" data-aos-delay="150">
                    <div class="text-4xl mb-4">⚡</div>
                    <h3 class="text-lg font-semibold text-blue-400 mb-3">Coordenação</h3>
                    <p class="text-gray-300 text-sm">
                        Movimentos precisos e reflexos rápidos.
                    </p>
                </div>
                
                <div class="bg-gray-900 border border-gray-600 rounded-xl p-6 text-center hover:scale-105 transition-transform" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-4xl mb-4">💎</div>
                    <h3 class="text-lg font-semibold text-blue-400 mb-3">Confiança</h3>
                    <p class="text-gray-300 text-sm">
                        Postura e segurança que se refletem na vida.
                    </p>
                </div>
                
                <div class="bg-gray-900 border border-gray-600 rounded-xl p-6 text-center hover:scale-105 transition-transform" data-aos="fade-up" data-aos-delay="250">
                    <div class="text-4xl mb-4">🎯</div>
                    <h3 class="text-lg font-semibold text-blue-400 mb-3">Disciplina</h3>
                    <p class="text-gray-300 text-sm">
                        Foco e organização mental para seus objetivos.
                    </p>
                </div>
                
                <div class="bg-gray-900 border border-gray-600 rounded-xl p-6 text-center hover:scale-105 transition-transform" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-4xl mb-4">📈</div>
                    <h3 class="text-lg font-semibold text-blue-400 mb-3">Evolução Rápida</h3>
                    <p class="text-gray-300 text-sm">
                        Progresso visível no seu ritmo de aprendizado.
                    </p>
                </div>
                
                <div class="bg-gray-900 border border-gray-600 rounded-xl p-6 text-center hover:scale-105 transition-transform" data-aos="fade-up" data-aos-delay="350">
                    <div class="text-4xl mb-4">👁️</div>
                    <h3 class="text-lg font-semibold text-blue-400 mb-3">Atenção Total do Professor</h3>
                    <p class="text-gray-300 text-sm">
                        Correção individual e acompanhamento direto.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sobre o Instrutor -->
    <section id="instrutor" class="py-20 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-400 mb-6">Seu Instrutor</h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Experiência que gera confiança e resultados reais.
                </p>
            </div>
            
            <div class="max-w-4xl mx-auto">
                @if($professor)
                    <div class="grid md:grid-cols-2 gap-12 items-center" data-aos="fade-up" data-aos-delay="100">
                        <!-- Slider de Fotos do Instrutor -->
                        <div class="order-2 md:order-1">
                            @php
                                $imagensProfessor = json_decode($professor->imagens_professor ?? '[]', true);
                            @endphp
                            
                            @if(!empty($imagensProfessor))
                                <div class="relative slider-container">
                                    @foreach($imagensProfessor as $indice => $imagem)
                                        <div class="slide">
                                            <img src="{{ asset($imagem) }}" 
                                                 alt="{{ $professor->name }} - Foto {{ $indice + 1 }}" 
                                                 class="w-full h-80 object-cover rounded-xl shadow-2xl">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent rounded-xl"></div>
                                        </div>
                                    @endforeach
                                    
                                    <!-- Indicadores do Slider -->
                                    @if(count($imagensProfessor) > 1)
                                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2">
                                            @foreach($imagensProfessor as $indice => $imagem)
                                                <button class="slider-indicator w-2 h-2 rounded-full transition-all {{ $indice === 0 ? 'bg-blue-400' : 'bg-white/50' }}" 
                                                        data-slide="{{ $indice }}"></button>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="relative">
                                    <div class="w-full h-80 bg-gradient-section border border-gray-600 rounded-xl flex items-center justify-center">
                                        <div class="text-center text-gray-400">
                                            <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            <p>Foto em breve</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Informações do Instrutor -->
                        <div class="order-1 md:order-2">
                            <div class="bg-gradient-section border border-gray-600 rounded-xl p-8">
                                <h3 class="text-2xl font-bold text-blue-400 mb-6">{{ $professor->name }}</h3>
                                
                                <div class="space-y-4">
                                    <div class="flex items-start gap-3">
                                        <div class="bg-blue-600 p-2 rounded-full mt-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-white font-semibold">{{ $professor->anos_boxe }} {{ $professor->anos_boxe == 1 ? 'ano' : 'anos' }} de boxe</p>
                                            <p class="text-gray-300 text-sm">Experiência sólida na arte marcial</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start gap-3">
                                        <div class="bg-blue-600 p-2 rounded-full mt-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-white font-semibold">{{ $professor->anos_instrutor }} {{ $professor->anos_instrutor == 1 ? 'ano' : 'anos' }} como instrutor</p>
                                            <p class="text-gray-300 text-sm">Formação e prática no ensino</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start gap-3">
                                        <div class="bg-blue-600 p-2 rounded-full mt-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-white font-semibold">Instrutor Especializado</p>
                                            <p class="text-gray-300 text-sm">Metodologia personalizada para cada aluno</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-6 p-4 bg-gray-800 rounded-lg border-l-4 border-blue-600">
                                    <p class="text-gray-300 italic">
                                        "{{ $professor->descricao_professor }}"
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Fallback caso não tenha professor cadastrado -->
                    <div class="grid md:grid-cols-2 gap-12 items-center">
                        <!-- Foto do Instrutor -->
                        <div class="order-2 md:order-1">
                            <div class="relative">
                                <div class="w-full h-80 bg-gradient-section border border-gray-600 rounded-xl flex items-center justify-center">
                                    <div class="text-center text-gray-400">
                                        <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <p>Informações do professor em breve</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Informações do Instrutor -->
                        <div class="order-1 md:order-2">
                            <div class="bg-gradient-section border border-gray-600 rounded-xl p-8">
                                <h3 class="text-2xl font-bold text-blue-400 mb-6">Nosso Instrutor</h3>
                                <p class="text-gray-300">Informações sobre o instrutor serão atualizadas em breve.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Avaliações dos Alunos -->
    @if($avaliacoes->isNotEmpty())
    <section id="avaliacoes" class="py-20 bg-gradient-section">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-400 mb-6">O que Nossos Alunos Dizem</h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Depoimentos reais de quem treina conosco e vive a experiência Boxing House PF.
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($avaliacoes as $avaliacao)
                    <div class="bg-gray-900 border border-gray-600 rounded-xl p-6 hover:scale-105 transition-transform duration-300" data-aos="fade-up" data-aos-delay="{{ 100 + ($loop->index * 100) }}">
                        <!-- Header com foto e nome -->
                        <div class="flex items-center gap-4 mb-4">
                            @if($avaliacao->foto_avaliacao)
                                <img src="{{ asset($avaliacao->foto_avaliacao) }}"  
                                     alt="Foto de {{ $avaliacao->user->name }}" 
                                     class="w-12 h-12 rounded-full object-cover border-2 border-blue-400">
                            @else
                                <div class="w-12 h-12 rounded-full bg-gradient-blue flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <h3 class="text-white font-semibold">{{ $avaliacao->user->name }}</h3>
                                <p class="text-gray-400 text-sm">Aluno</p>
                            </div>
                        </div>
                        
                        <!-- Comentário -->
                        <div class="relative">
                            <!-- Aspas decorativas -->
                            <div class="absolute -top-2 -left-2 text-4xl text-blue-400/30 font-serif">"</div>
                            <p class="text-gray-300 italic pl-6 pr-4 relative z-10">
                                {{ $avaliacao->comentario }}
                            </p>
                            <div class="absolute -bottom-2 -right-2 text-4xl text-blue-400/30 font-serif rotate-180">"</div>
                        </div>
                        
                        <!-- Data da avaliação -->
                        <div class="mt-4 pt-4 border-t border-gray-700">
                            <p class="text-gray-400 text-xs">
                                {{ $avaliacao->created_at->format('M Y') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Galeria de Fotos -->
    @if($fotosCentro->isNotEmpty())
    <section id="galeria" class="py-20 bg-gradient-section">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-400 mb-6">Nosso Centro de Treinamento</h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Espaço compacto e organizado, fechado e sem distrações: foco no treino e na técnica.
                </p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                @foreach($fotosCentro->take(6) as $foto)
                    <div class="group relative overflow-hidden rounded-xl shadow-2xl hover:shadow-3xl transition-all duration-300 cursor-pointer" data-aos="fade-up" data-aos-delay="{{ 100 + ($loop->index * 80) }}" 
                         onclick="openPhotoModal('{{ asset($foto->caminho_arquivo) }}', '{{ $foto->descricao ?: 'Foto do centro de treinamento' }}')">
                        <img src="{{ asset($foto->caminho_arquivo) }}" 
                             alt="{{ $foto->descricao ?: 'Foto do centro de treinamento' }}" 
                             class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end">
                            @if($foto->descricao)
                                <div class="p-4 w-full">
                                    <p class="text-white font-semibold text-center">{{ $foto->descricao }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <div class="bg-white/20 rounded-full p-3">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Horários -->
    @if($horarios->isNotEmpty())
    <section id="horarios" class="py-20 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-400 mb-6">Horários de Funcionamento</h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Confira nossos horários disponíveis e escolha o melhor para sua rotina.
                </p>
            </div>
            
            <div class="bg-gradient-section border border-gray-600 rounded-xl p-8 max-w-4xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                <div class="grid gap-4">
                    @php
                        $diasSemana = [
                            1 => 'Segunda',
                            2 => 'Terça', 
                            3 => 'Quarta',
                            4 => 'Quinta',
                            5 => 'Sexta',
                            6 => 'Sábado',
                            7 => 'Domingo'
                        ];
                    @endphp
                    @foreach($horarios as $diaNumero => $horariosDay)
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between py-4 border-b border-gray-600 last:border-b-0">
                            <div class="font-semibold text-blue-400 text-lg mb-2 md:mb-0">
                                {{ ($diasSemana[$diaNumero] ?? 'Dia '.$diaNumero) . (in_array($diaNumero, [6, 7]) ? '' : '-feira') }}
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @foreach($horariosDay as $horario)
                                    @php
                                        $inicio = \Carbon\Carbon::parse($horario->hora_inicio);
                                        $fim = $inicio->copy()->addMinutes(70); // 1h10min
                                    @endphp
                                    <span class="px-3 py-1 bg-blue-600 text-white rounded-full text-sm">
                                        {{ $inicio->format('H:i') }} até {{ $fim->format('H:i') }} horas
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Valores -->
    @if($valores->isNotEmpty())
    <section id="valores" class="py-20 bg-gradient-section">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-400 mb-6">Planos e Valores</h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Escolha o plano que melhor se adapta à sua rotina e objetivos.
                </p>
            </div>
            @php
                $planos = $valores->where('vezes_semana', '<=', 4);
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-{{ min(count($planos), 4) }} gap-8 max-w-6xl mx-auto">
                @foreach($planos as $valor)
                    <div class="bg-gray-900 border border-gray-600 rounded-xl p-8 text-center hover:scale-105 hover:border-blue-500 transition-all duration-300 relative overflow-hidden" data-aos="fade-up" data-aos-delay="{{ 100 + ($loop->index * 100) }}">
                        @if($loop->iteration == 2)
                            <div class="absolute top-0 left-0 right-0 bg-blue-600 text-white text-sm font-semibold py-2">
                                Mais Popular
                            </div>
                        @endif
                        
                        <div class="text-3xl mb-4">
                            @if($valor->vezes_semana == 1) 🥉
                            @elseif($valor->vezes_semana == 2) 🥈
                            @elseif($valor->vezes_semana == 3) 🥇
                            @else ⭐
                            @endif
                        </div>
                        
                        <h3 class="text-2xl font-bold text-blue-400 mb-4">
                            {{ $valor->vezes_semana }}x por semana
                        </h3>
                        
                        <div class="text-4xl font-bold text-white mb-6">
                            R$ {{ number_format($valor->valor, 2, ',', '.') }}
                            <span class="text-lg text-gray-400 font-normal">/mês</span>
                        </div>
                        
                        <div class="text-gray-300 mb-8">
                            {{ $valor->vezes_semana }} {{ $valor->vezes_semana == 1 ? 'treino' : 'treinos' }} por semana
                        </div>
                        
                        @if($config && $config->whatsapp)
                            <a href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}?text=Olá! Gostaria de saber mais sobre o plano {{ $valor->vezes_semana }}x por semana" 
                               target="_blank"
                               class="w-full bg-green-600 hover:bg-green-700 px-6 py-3 rounded-lg font-semibold transition-colors inline-flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                </svg>
                                Contratar Plano
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>

            @php
                $aulaAvulsa = $valores->firstWhere('vezes_semana', 5);
            @endphp
            @if($aulaAvulsa)
                <div class="mt-12 max-w-4xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-gray-900 border border-blue-600 rounded-2xl p-8 text-center relative overflow-hidden">
                        <div class="absolute -top-12 -right-12 w-48 h-48 bg-blue-600/10 rounded-full blur-2xl"></div>
                        <h3 class="text-2xl font-bold text-blue-400 mb-2">Aula Avulsa</h3>
                        <p class="text-gray-300 mb-6">Se você não quer fazer plano mensal, há a opção de aula avulsa.</p>
                        <div class="text-4xl font-bold text-white mb-6">
                            R$ {{ number_format($aulaAvulsa->valor, 2, ',', '.') }}
                            <span class="text-lg text-gray-400 font-normal">/aula</span>
                        </div>
                        @if($config && $config->whatsapp)
                            <a href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}?text=Olá! Gostaria de agendar uma aula avulsa" 
                               target="_blank"
                               class="w-full bg-green-600 hover:bg-green-700 px-6 py-3 rounded-lg font-semibold transition-colors inline-flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                </svg>
                                Agendar Aula Avulsa
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </section>
    @endif

    <!-- Sistema do Aluno -->
    <section id="sistema" class="py-20 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-400 mb-6">
                    {{ $sistemaAluno->titulo ?? 'Sistema do Aluno' }}
                </h2>
                @if($sistemaAluno && $sistemaAluno->descricao)
                    <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                        {{ $sistemaAluno->descricao }}
                    </p>
                @else
                    <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                        Acompanhe sua evolução, aulas participadas e mais — tudo em um só lugar.
                    </p>
                @endif
            </div>

            <div class="grid lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Resumo -->
                <div class="bg-gradient-section border border-gray-600 rounded-xl p-8" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="text-2xl font-semibold text-blue-400 mb-4">Resumo</h3>
                    <ul class="space-y-3 text-gray-300">
                        @if($sistemaAluno && $sistemaAluno->resumo_items)
                            @foreach($sistemaAluno->resumo_items as $item)
                                <li>• {{ $item }}</li>
                            @endforeach
                        @else
                            <li>• Evolução real no seu ritmo</li>
                            <li>• Registro de aulas participadas</li>
                            <li>• Acesso simples pela área do aluno</li>
                        @endif
                    </ul>
                    <div class="mt-6">
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 border-2 border-white px-5 py-3 rounded-lg font-semibold hover:bg-white hover:text-gray-900 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Área do Aluno
                        </a>
                    </div>
                </div>

                <!-- Detalhes -->
                <div class="bg-gray-900 border border-gray-600 rounded-xl p-8" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="text-2xl font-semibold text-blue-400 mb-4">Detalhes</h3>
                    <p class="text-gray-300">
                        @if($sistemaAluno && $sistemaAluno->detalhes)
                            {{ $sistemaAluno->detalhes }}
                        @else
                            Visualize sua participação nas aulas e o progresso ao longo do tempo. Tenha clareza sobre sua evolução técnica, com foco no que importa.
                        @endif
                    </p>
                </div>

                <!-- Imagens do Sistema -->
                @if($sistemaAluno && $sistemaAluno->imagens && count($sistemaAluno->imagens) > 0)
                    <div class="bg-gradient-section border border-gray-600 rounded-xl p-8" data-aos="fade-up" data-aos-delay="300">
                        <h3 class="text-2xl font-semibold text-blue-400 mb-4">Sistema</h3>
                        
                        <div class="relative sistema-slider-container">
                            @foreach($sistemaAluno->imagens as $indice => $imagem)
                                <div class="sistema-slide">
                                    <img src="{{ asset($imagem) }}" 
                                         alt="Sistema do Aluno - Imagem {{ $indice + 1 }}" 
                                         style="width: 100%; height: auto;" 
                                         class="rounded-lg shadow-lg">
                                </div>
                            @endforeach
                            
                            <!-- Indicadores do Slider -->
                            @if(count($sistemaAluno->imagens) > 1)
                                <div class="absolute bottom-2 left-1/2 transform -translate-x-1/2 flex gap-2">
                                    @foreach($sistemaAluno->imagens as $indice => $imagem)
                                        <button class="sistema-slider-indicator w-2 h-2 rounded-full transition-all {{ $indice === 0 ? 'bg-blue-400' : 'bg-white/50' }}" 
                                                data-slide="{{ $indice }}"></button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Localização -->
    @if($config && $config->maps_src)
    <section id="localizacao" class="py-20 bg-gradient-section">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-400 mb-6">Nossa Localização</h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Ambiente fechado e organizado, ideal para treino focado sem distrações.
                </p>
            </div>
            
            <div class="bg-gray-900 border border-gray-600 rounded-xl overflow-hidden shadow-2xl" data-aos="fade-up" data-aos-delay="200">
                <iframe src="{{ $config->maps_src }}" 
                        width="100%" 
                        height="500" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                        class="w-full">
                </iframe>
            </div>
            
            <div class="mt-8 text-center" data-aos="fade-up" data-aos-delay="300">
                <div class="inline-flex items-center gap-2 bg-gray-900 border border-gray-600 rounded-lg px-6 py-4">
                    <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <div class="text-left">
                        <p class="text-white font-semibold">Boxing House PF</p>
                        <p class="text-gray-300">
                            @if($config && ($config->bairro || $config->cidade))
                                {{ $config->bairro ? $config->bairro.' - ' : '' }}{{ $config->cidade ?: 'Passo Fundo' }}, RS
                                @if($config->rua && $config->numero)
                                     • {{ $config->rua }}, {{ $config->numero }}
                                @elseif($config->rua)
                                     • {{ $config->rua }}
                                @endif
                            @else
                                Centro - Passo Fundo, RS • Rua Exemplo, 123
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Contato -->
    <section id="contato" class="py-20 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-400 mb-6">Entre em Contato</h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Venha nos visitar ou entre em contato para mais informações.
                </p>
            </div>
            
            <div class="max-w-4xl mx-auto">
                <!-- Informações de Contato -->
                <div class="space-y-8">
                    <div class="bg-gradient-section border border-gray-600 rounded-xl p-8" data-aos="fade-up" data-aos-delay="200">
                        <h3 class="text-2xl font-semibold text-blue-400 mb-6">Informações de Contato</h3>
                        
                        <div class="space-y-6">
                            @if($config && $config->whatsapp)
                                <div class="flex items-center gap-4">
                                    <div class="bg-green-600 p-3 rounded-full">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-gray-400">WhatsApp</p>
                                        <a href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}" target="_blank" 
                                           class="text-white font-semibold hover:text-green-400 transition-colors">
                                            {{ $config->whatsapp }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                            
                            @if($config && $config->email)
                                <div class="flex items-center gap-4">
                                    <div class="bg-blue-600 p-3 rounded-full">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-gray-400">Email</p>
                                        <a href="mailto:{{ $config->email }}" 
                                           class="text-white font-semibold hover:text-blue-400 transition-colors">
                                            {{ $config->email }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="flex items-center gap-4">
                                <div class="bg-purple-600 p-3 rounded-full">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-gray-400">Instagram</p>
                                    @if($config && $config->instagram)
                                        <a href="https://instagram.com/{{ ltrim($config->instagram, '@') }}" target="_blank" 
                                           class="text-white font-semibold hover:text-purple-400 transition-colors">
                                            {{ $config->instagram }}
                                        </a>
                                    @else
                                        <span class="text-gray-500">Não informado</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4">
                                <div class="bg-red-600 p-3 rounded-full">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-gray-400">Localização</p>
                                    <p class="text-white font-semibold">
                                        @if($config && ($config->bairro || $config->cidade))
                                            {{ $config->bairro ? $config->bairro.' - ' : '' }}{{ $config->cidade ?: 'Passo Fundo' }}, RS
                                            @if($config->rua && $config->numero)
                                                <br>{{ $config->rua }}, {{ $config->numero }}
                                            @elseif($config->rua)
                                                <br>{{ $config->rua }}
                                            @endif
                                        @else
                                            Centro - Passo Fundo, RS<br>Rua Exemplo, 123
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        @if($config && $config->whatsapp)
                            <div class="mt-8">
                                <a href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}?text=Olá! Gostaria de conhecer a Boxing House PF" 
                                   target="_blank"
                                   class="w-full bg-green-600 hover:bg-green-700 px-6 py-4 rounded-lg font-semibold transition-colors inline-flex items-center justify-center gap-2 text-lg">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                    </svg>
                                    Fale Conosco no WhatsApp
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Final -->
    <section class="py-20 bg-gradient-hero">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Pronto para Começar?</h2>
                <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                    Studio de boxe feito em casa, sem lotação e sem treino genérico. Atendimento individual ou grupos pequenos, com foco em técnica e evolução.
                </p>
            
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center px-4" data-aos="fade-up" data-aos-delay="200">
                @if($config && $config->whatsapp)
                    <a href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}?text=Olá! Gostaria de agendar uma aula experimental" 
                       target="_blank"
                       class="bg-green-600 hover:bg-green-700 px-6 sm:px-8 py-3 sm:py-4 rounded-lg text-base sm:text-lg font-semibold transition-colors inline-flex items-center justify-center gap-2 sm:gap-3 w-full sm:w-auto">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                        </svg>
                        Agendar Aula Experimental
                    </a>
                @endif
                
                <a href="{{ route('login') }}" 
                   class="border-2 border-white px-6 sm:px-8 py-3 sm:py-4 rounded-lg text-base sm:text-lg font-semibold hover:bg-white hover:text-gray-900 transition-colors inline-flex items-center justify-center gap-2 sm:gap-3 w-full sm:w-auto">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Área do Aluno
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 border-t border-gray-700 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex justify-center mb-4">
                <img src="{{ asset('logo-y.png') }}" alt="Boxing House PF" class="h-16 w-auto">
            </div>
            <p class="text-gray-400 mb-4">Studio de Boxe</p>
            <div class="flex justify-center gap-6 mb-4">
                @if($config && $config->whatsapp)
                    <a href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}" target="_blank" 
                       class="text-gray-400 hover:text-green-400 transition-colors">
                        WhatsApp
                    </a>
                @endif
                @if($config && $config->email)
                    <a href="mailto:{{ $config->email }}" class="text-gray-400 hover:text-blue-400 transition-colors">
                        Email
                    </a>
                @endif
            </div>
            <p class="text-gray-500 text-sm">
                © {{ date('Y') }} Boxing House PF. Todos os direitos reservados.
            </p>
        </div>
    </footer>

    <!-- Modal para Fotos -->
    <div id="photoModal" class="fixed inset-0 bg-black/90 z-50 hidden flex items-center justify-center p-4" onclick="closePhotoModal()">
        <div class="relative max-w-4xl max-h-full" onclick="event.stopPropagation()">
            <img id="modalPhoto" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg">
            <div class="absolute top-4 right-4">
                <button onclick="closePhotoModal()" class="bg-black/50 hover:bg-black/70 text-white p-2 rounded-full transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="modalDescription" class="absolute bottom-0 left-0 right-0 bg-black/70 text-white p-4 rounded-b-lg">
                <p class="text-center font-semibold"></p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <style>
        /* Slider de imagens do professor */
        .slider-container {
            position: relative;
            overflow: hidden;
            width: 100%;
            height: 320px; /* h-80 equivale a 320px */
        }
        
        .slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            transition: opacity 1s ease-in-out;
            opacity: 0;
        }
        
        .slide:first-child {
            position: relative;
            opacity: 1;
        }
        
        .slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .slider-indicator {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .slider-indicator:hover {
            opacity: 0.8;
            transform: scale(1.1);
        }
        
        /* Slider de imagens do sistema */
        .sistema-slider-container {
            position: relative;
            overflow: hidden;
            width: 100%;
            height: 192px; /* h-48 equivale a 192px */
        }
        
        .sistema-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            transition: opacity 1s ease-in-out;
            opacity: 0;
        }
        
        .sistema-slide:first-child {
            position: relative;
            opacity: 1;
        }
        
        .sistema-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .sistema-slider-indicator {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .sistema-slider-indicator:hover {
            opacity: 0.8;
            transform: scale(1.1);
        }
    </style>
    
    <script>
        // Modal de fotos
        function openPhotoModal(src, description) {
            const modal = document.getElementById('photoModal');
            const modalPhoto = document.getElementById('modalPhoto');
            const modalDescription = document.getElementById('modalDescription');
            
            modalPhoto.src = src;
            modalPhoto.alt = description;
            modalDescription.querySelector('p').textContent = description;
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        function closePhotoModal() {
            const modal = document.getElementById('photoModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        // Fechar modal com ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePhotoModal();
            }
        });
        
        // Smooth scrolling para navegação
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const headerOffset = 80;
                    const elementPosition = target.offsetTop;
                    const offsetPosition = elementPosition - headerOffset;
                    
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Header transparente no scroll
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');
            if (window.scrollY > 100) {
                header.classList.add('bg-gray-900');
                header.classList.remove('bg-gray-900/95');
            } else {
                header.classList.remove('bg-gray-900');
                header.classList.add('bg-gray-900/95');
            }
        });

        // Slider automático do professor
        document.addEventListener('DOMContentLoaded', function() {
            const sliderContainer = document.querySelector('.slider-container');
            if (!sliderContainer) return;
            
            const slides = sliderContainer.querySelectorAll('.slide');
            const indicators = sliderContainer.querySelectorAll('.slider-indicator');
            
            if (slides.length <= 1) return; // Não precisa de slider para 1 imagem ou menos
            
            let currentSlide = 0;
            let isTransitioning = false;
            
            // Inicializar - mostrar primeiro slide
            function initSlider() {
                slides.forEach((slide, index) => {
                    if (index === 0) {
                        slide.style.opacity = '1';
                        slide.style.position = 'relative';
                    } else {
                        slide.style.opacity = '0';
                        slide.style.position = 'absolute';
                        slide.style.top = '0';
                        slide.style.left = '0';
                        slide.style.width = '100%';
                    }
                });
                
                // Ativar primeiro indicador
                if (indicators.length > 0) {
                    indicators[0].classList.remove('bg-white/50');
                    indicators[0].classList.add('bg-blue-400');
                }
            }
            
            function showSlide(index) {
                if (isTransitioning || index === currentSlide) return;
                isTransitioning = true;
                
                const currentSlideEl = slides[currentSlide];
                const nextSlideEl = slides[index];
                
                // Fade out do slide atual
                currentSlideEl.style.opacity = '0';
                
                // Preparar próximo slide
                nextSlideEl.style.position = 'absolute';
                nextSlideEl.style.top = '0';
                nextSlideEl.style.left = '0';
                nextSlideEl.style.width = '100%';
                nextSlideEl.style.opacity = '0';
                
                // Fade in do próximo slide após pequeno delay
                setTimeout(() => {
                    nextSlideEl.style.opacity = '1';
                    
                    // Após a transição, ajustar posições
                    setTimeout(() => {
                        currentSlideEl.style.position = 'absolute';
                        nextSlideEl.style.position = 'relative';
                        
                        // Atualizar indicadores
                        indicators.forEach((indicator, i) => {
                            if (i === index) {
                                indicator.classList.remove('bg-white/50');
                                indicator.classList.add('bg-blue-400');
                            } else {
                                indicator.classList.remove('bg-blue-400');
                                indicator.classList.add('bg-white/50');
                            }
                        });
                        
                        currentSlide = index;
                        isTransitioning = false;
                    }, 1000); // Tempo da transição CSS
                }, 50);
            }
            
            function nextSlide() {
                const nextIndex = (currentSlide + 1) % slides.length;
                showSlide(nextIndex);
            }
            
            // Controle manual pelos indicadores
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    showSlide(index);
                });
            });
            
            // Inicializar slider
            initSlider();
            
            // Auto slide a cada 4 segundos
            setInterval(nextSlide, 4000);
        });

        // Slider automático do sistema
        document.addEventListener('DOMContentLoaded', function() {
            const sistemaSliderContainer = document.querySelector('.sistema-slider-container');
            if (!sistemaSliderContainer) return;
            
            const sistemaSlides = sistemaSliderContainer.querySelectorAll('.sistema-slide');
            const sistemaIndicators = sistemaSliderContainer.querySelectorAll('.sistema-slider-indicator');
            
            if (sistemaSlides.length <= 1) return; // Não precisa de slider para 1 imagem ou menos
            
            let sistemaCurrentSlide = 0;
            let sistemaIsTransitioning = false;
            
            // Inicializar - mostrar primeiro slide
            function initSistemaSlider() {
                sistemaSlides.forEach((slide, index) => {
                    if (index === 0) {
                        slide.style.opacity = '1';
                        slide.style.position = 'relative';
                    } else {
                        slide.style.opacity = '0';
                        slide.style.position = 'absolute';
                        slide.style.top = '0';
                        slide.style.left = '0';
                        slide.style.width = '100%';
                    }
                });
                
                // Ativar primeiro indicador
                if (sistemaIndicators.length > 0) {
                    sistemaIndicators[0].classList.remove('bg-white/50');
                    sistemaIndicators[0].classList.add('bg-blue-400');
                }
            }
            
            function showSistemaSlide(index) {
                if (sistemaIsTransitioning || index === sistemaCurrentSlide) return;
                sistemaIsTransitioning = true;
                
                const currentSlideEl = sistemaSlides[sistemaCurrentSlide];
                const nextSlideEl = sistemaSlides[index];
                
                // Fade out do slide atual
                currentSlideEl.style.opacity = '0';
                
                // Preparar próximo slide
                nextSlideEl.style.position = 'absolute';
                nextSlideEl.style.top = '0';
                nextSlideEl.style.left = '0';
                nextSlideEl.style.width = '100%';
                nextSlideEl.style.opacity = '0';
                
                // Fade in do próximo slide após pequeno delay
                setTimeout(() => {
                    nextSlideEl.style.opacity = '1';
                    
                    // Após a transição, ajustar posições
                    setTimeout(() => {
                        currentSlideEl.style.position = 'absolute';
                        nextSlideEl.style.position = 'relative';
                        
                        // Atualizar indicadores
                        sistemaIndicators.forEach((indicator, i) => {
                            if (i === index) {
                                indicator.classList.remove('bg-white/50');
                                indicator.classList.add('bg-blue-400');
                            } else {
                                indicator.classList.remove('bg-blue-400');
                                indicator.classList.add('bg-white/50');
                            }
                        });
                        
                        sistemaCurrentSlide = index;
                        sistemaIsTransitioning = false;
                    }, 1000); // Tempo da transição CSS
                }, 50);
            }
            
            function nextSistemaSlide() {
                const nextIndex = (sistemaCurrentSlide + 1) % sistemaSlides.length;
                showSistemaSlide(nextIndex);
            }
            
            // Controle manual pelos indicadores
            sistemaIndicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    showSistemaSlide(index);
                });
            });
            
            // Inicializar slider
            initSistemaSlider();
            
            // Auto slide a cada 5 segundos (diferente do slider do professor para não sincronizarem)
            setInterval(nextSistemaSlide, 5000);
        });
    </script>
@endsection