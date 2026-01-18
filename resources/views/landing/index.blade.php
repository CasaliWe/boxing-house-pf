<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boxing House PF - Academia de Boxe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-gradient-hero {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        }
        .bg-gradient-section {
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
        }
        .scroll-smooth {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="bg-gray-900 text-white scroll-smooth">

    <!-- Header/Navegação -->
    <header class="fixed w-full top-0 z-50 bg-gray-900/95 backdrop-blur-sm border-b border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <h1 class="text-xl font-bold text-blue-400 tracking-wide">Boxing House PF</h1>
                <nav class="hidden md:flex space-x-8">
                    <a href="#home" class="text-gray-300 hover:text-blue-400 transition-colors">Início</a>
                    <a href="#sobre" class="text-gray-300 hover:text-blue-400 transition-colors">Sobre</a>
                    <a href="#horarios" class="text-gray-300 hover:text-blue-400 transition-colors">Horários</a>
                    <a href="#galeria" class="text-gray-300 hover:text-blue-400 transition-colors">Galeria</a>
                    <a href="#valores" class="text-gray-300 hover:text-blue-400 transition-colors">Valores</a>
                    <a href="#contato" class="text-gray-300 hover:text-blue-400 transition-colors">Contato</a>
                </nav>
                <div class="flex items-center gap-4">
                    @if($config && $config->whatsapp)
                        <a href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}" target="_blank" 
                           class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            WhatsApp
                        </a>
                    @endif
                    <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        Entrar
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="home" class="min-h-screen bg-gradient-hero flex items-center relative overflow-hidden">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                    Desperte o <span class="text-yellow-400">Campeão</span><br>
                    que há em Você
                </h1>
                <p class="text-xl md:text-2xl text-blue-100 mb-8 max-w-3xl mx-auto leading-relaxed">
                    Academia de boxe profissional em Passo Fundo. Treine com os melhores equipamentos e técnicas para alcançar seus objetivos.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    @if($config && $config->whatsapp)
                        <a href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}?text=Olá! Gostaria de saber mais sobre a Boxing House PF" 
                           target="_blank" 
                           class="bg-green-600 hover:bg-green-700 px-8 py-4 rounded-lg text-lg font-semibold transition-colors flex items-center gap-2 shadow-lg">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                            </svg>
                            Fale Conosco
                        </a>
                    @endif
                    <a href="#sobre" class="border-2 border-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-white hover:text-gray-900 transition-colors">
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
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-400 mb-6">Sobre a Boxing House PF</h2>
                <p class="text-xl text-gray-300 max-w-4xl mx-auto leading-relaxed">
                    Uma academia especializada em boxe, localizada em Passo Fundo, que oferece treinamento profissional 
                    para todos os níveis. Do iniciante ao atleta avançado, proporcionamos um ambiente seguro e motivador 
                    para seu desenvolvimento físico e técnico.
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-gradient-section border border-gray-600 rounded-xl p-8 text-center hover:scale-105 transition-transform">
                    <div class="text-4xl mb-4">🥊</div>
                    <h3 class="text-xl font-semibold text-blue-400 mb-4">Treinamento Profissional</h3>
                    <p class="text-gray-300">
                        Técnicas avançadas de boxe com instrutor qualificado e experiente no esporte.
                    </p>
                </div>
                
                <div class="bg-gradient-section border border-gray-600 rounded-xl p-8 text-center hover:scale-105 transition-transform">
                    <div class="text-4xl mb-4">💪</div>
                    <h3 class="text-xl font-semibold text-blue-400 mb-4">Condicionamento Físico</h3>
                    <p class="text-gray-300">
                        Desenvolva força, resistência e agilidade com nossos treinos personalizados.
                    </p>
                </div>
                
                <div class="bg-gradient-section border border-gray-600 rounded-xl p-8 text-center hover:scale-105 transition-transform">
                    <div class="text-4xl mb-4">🎯</div>
                    <h3 class="text-xl font-semibold text-blue-400 mb-4">Resultados Garantidos</h3>
                    <p class="text-gray-300">
                        Metodologia comprovada para alcançar seus objetivos, seja fitness ou competição.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Galeria de Fotos -->
    @if($fotosCentro->isNotEmpty())
    <section id="galeria" class="py-20 bg-gradient-section">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-400 mb-6">Nosso Centro de Treinamento</h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Conheça nossas instalações modernas e equipamentos de primeira linha.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($fotosCentro->take(6) as $foto)
                    <div class="group relative overflow-hidden rounded-xl shadow-2xl hover:shadow-3xl transition-all duration-300">
                        <img src="{{ asset('storage/'.$foto->caminho_arquivo) }}" 
                             alt="{{ $foto->descricao ?: 'Foto do centro de treinamento' }}" 
                             class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            @if($foto->descricao)
                                <div class="absolute bottom-4 left-4 right-4">
                                    <p class="text-white font-semibold">{{ $foto->descricao }}</p>
                                </div>
                            @endif
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
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-400 mb-6">Horários de Funcionamento</h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Confira nossos horários disponíveis e escolha o melhor para sua rotina.
                </p>
            </div>
            
            <div class="bg-gradient-section border border-gray-600 rounded-xl p-8 max-w-4xl mx-auto">
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
                                {{ $diasSemana[$diaNumero] ?? 'Dia '.$diaNumero }}-feira
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @foreach($horariosDay as $horario)
                                    <span class="px-3 py-1 bg-blue-600 text-white rounded-full text-sm">
                                        {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }}
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
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-400 mb-6">Planos e Valores</h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Escolha o plano que melhor se adapta à sua rotina e objetivos.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-{{ min(count($valores), 4) }} gap-8 max-w-6xl mx-auto">
                @foreach($valores as $valor)
                    <div class="bg-gray-900 border border-gray-600 rounded-xl p-8 text-center hover:scale-105 hover:border-blue-500 transition-all duration-300 relative overflow-hidden">
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
                               class="w-full bg-green-600 hover:bg-green-700 px-6 py-3 rounded-lg font-semibold transition-colors inline-block">
                                Contratar Plano
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Mapa e Contato -->
    <section id="contato" class="py-20 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-400 mb-6">Entre em Contato</h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Venha nos visitar ou entre em contato para mais informações.
                </p>
            </div>
            
            <div class="grid lg:grid-cols-2 gap-12">
                <!-- Informações de Contato -->
                <div class="space-y-8">
                    <div class="bg-gradient-section border border-gray-600 rounded-xl p-8">
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
                                <div class="bg-red-600 p-3 rounded-full">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-gray-400">Localização</p>
                                    <p class="text-white font-semibold">Passo Fundo, RS</p>
                                </div>
                            </div>
                        </div>
                        
                        @if($config && $config->whatsapp)
                            <div class="mt-8">
                                <a href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}?text=Olá! Gostaria de conhecer a Boxing House PF" 
                                   target="_blank"
                                   class="w-full bg-green-600 hover:bg-green-700 px-6 py-4 rounded-lg font-semibold transition-colors inline-block text-center text-lg">
                                    Fale Conosco no WhatsApp
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Mapa -->
                @if($config && $config->maps_src)
                    <div class="bg-gradient-section border border-gray-600 rounded-xl overflow-hidden">
                        <iframe src="{{ $config->maps_src }}" 
                                width="100%" 
                                height="450" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade"
                                class="w-full h-96 lg:h-full">
                        </iframe>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- CTA Final -->
    <section class="py-20 bg-gradient-hero">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Pronto para Começar?</h2>
            <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                Venha conhecer a Boxing House PF e descubra como o boxe pode transformar sua vida. 
                Agende uma aula experimental!
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @if($config && $config->whatsapp)
                    <a href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}?text=Olá! Gostaria de agendar uma aula experimental" 
                       target="_blank"
                       class="bg-green-600 hover:bg-green-700 px-8 py-4 rounded-lg text-lg font-semibold transition-colors inline-flex items-center justify-center gap-2">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                        </svg>
                        Agendar Aula Experimental
                    </a>
                @endif
                
                <a href="{{ route('login') }}" 
                   class="border-2 border-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-white hover:text-gray-900 transition-colors">
                    Área do Aluno
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 border-t border-gray-700 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h3 class="text-2xl font-bold text-blue-400 mb-4">Boxing House PF</h3>
            <p class="text-gray-400 mb-4">Academia de Boxe - Passo Fundo, RS</p>
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

    <!-- Scripts -->
    <script>
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
    </script>
</body>
</html>