@extends('layouts.landing')

@section('title', 'Planos e Valores - Boxing House PF')
@section('description', 'Conheça os planos e valores da Boxing House PF. Treino personalizado de boxe com opções de 1 a 4 vezes por semana e aula avulsa.')
@section('keywords', 'planos boxe, valores boxe, preços boxe, aula avulsa boxe, boxing house pf')

@section('og_title', 'Planos e Valores - Boxing House PF')
@section('og_description', 'Conheça os planos e valores da Boxing House PF. Treino personalizado de boxe.')

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
                    @if($config && $config->whatsapp)
                        <a href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}" target="_blank" 
                           class="bg-green-600 hover:bg-green-700 px-3 py-2 md:px-4 md:py-2 rounded-lg text-xs md:text-sm font-medium transition-colors flex items-center gap-1 md:gap-2">
                            <svg class="w-3 h-3 md:w-4 md:h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                            </svg>
                            <span class="hidden sm:inline">WhatsApp</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Conteúdo de Valores -->
    @if($valores->isNotEmpty())
    <section class="pt-32 pb-20 bg-gradient-section min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h1 class="text-3xl md:text-4xl font-bold text-blue-400 mb-6">Planos e Valores</h1>
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
    @else
    <section class="pt-32 pb-20 bg-gradient-section min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center py-20">
                <h1 class="text-3xl md:text-4xl font-bold text-blue-400 mb-6">Planos e Valores</h1>
                <p class="text-xl text-gray-300">Nenhum plano cadastrado no momento.</p>
            </div>
        </div>
    </section>
    @endif

    <!-- Footer -->
    <footer class="bg-gray-900 border-t border-gray-700 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex justify-center mb-4">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('logo-y.png') }}" alt="Boxing House PF" class="h-16 w-auto">
                </a>
            </div>
            <p class="text-gray-400 mb-4">Studio de Boxe</p>
            <p class="text-gray-500 text-sm">
                © {{ date('Y') }} Boxing House PF. Todos os direitos reservados.
            </p>
        </div>
    </footer>
@endsection
