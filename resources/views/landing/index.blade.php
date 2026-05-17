@extends('layouts.landing')

@section('title', 'Boxing House PF - Aulas Personais de Boxe | 1 ou 2 alunos por vez')
@section('description', 'Aulas personais de boxe em ambiente fechado, com 1 ou 2 alunos por vez. Acompanhamento direto, correção técnica e treino de 1 hora pensado pra você.')
@section('keywords', 'aula personal de boxe, boxe individual, treino sob medida, correção técnica, ambiente fechado, condicionamento físico, técnica')

@section('og_title', 'Boxing House PF - Aulas Personais de Boxe')
@section('og_description', 'Aulas personais de boxe com 1 ou 2 alunos por vez. Foco total, acompanhamento direto e correção técnica em tempo real.')

@section('content')

    {{-- ============================== HEADER ============================== --}}
    <header id="site-header" class="fixed w-full top-0 z-50 transition-all duration-500 bg-gray-950/40 backdrop-blur-md border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-3">
                <a href="#home" class="flex items-center group">
                    <img src="{{ asset('logo-x.png') }}" alt="Boxing House PF" class="h-8 md:h-9 w-auto transition-transform duration-300 group-hover:scale-105">
                </a>
                <nav class="hidden md:flex space-x-6">
                    <a href="#home"        class="nav-link text-[13px] font-medium">Início</a>
                    <a href="#sobre"       class="nav-link text-[13px] font-medium">Sobre</a>
                    <a href="#horarios"    class="nav-link text-[13px] font-medium">Horários</a>
                    <a href="#avaliacoes"  class="nav-link text-[13px] font-medium">Avaliações</a>
                    <a href="#galeria"     class="nav-link text-[13px] font-medium">Galeria</a>
                    <a href="#localizacao" class="nav-link text-[13px] font-medium">Local</a>
                    <a href="#contato"     class="nav-link text-[13px] font-medium">Contato</a>
                </nav>
                <div class="flex items-center gap-2">
                    @if($config && $config->whatsapp)
                        <a href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}" target="_blank"
                           data-analytics="clique_whatsapp" data-analytics-nome="header"
                           class="btn-primary btn-shine inline-flex items-center gap-1.5 px-3 py-1.5 md:py-2 rounded-md text-xs font-semibold">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/></svg>
                            <span class="hidden sm:inline">WhatsApp</span>
                        </a>
                    @endif
                    <a href="{{ route('login') }}" data-analytics="clique_login" data-analytics-nome="header"
                       class="btn-blue btn-shine inline-flex items-center gap-1.5 px-3 py-1.5 md:py-2 rounded-md text-xs font-semibold">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span class="hidden sm:inline">Área do aluno</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    {{-- ============================== HERO ============================== --}}
    <section id="home" class="relative min-h-screen hero-bg flex items-center overflow-hidden">
        <div class="blob blob-blue w-[420px] h-[420px] top-[15%] -left-32 animate-mesh-shift"></div>
        <div class="blob blob-cyan w-[340px] h-[340px] bottom-[10%] -right-24 animate-mesh-shift" style="animation-delay: -6s;"></div>
        <div class="grid-pattern"></div>
        <div class="noise-overlay"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="text-center max-w-4xl mx-auto pt-24 md:pt-16">
                <h1 class="font-display text-3xl sm:text-4xl md:text-5xl lg:text-[3.5rem] font-bold mb-5 leading-[1.1]"
                    data-aos="fade-up" data-aos-delay="100">
                    <span class="text-white">Boxe pessoal,</span><br class="hidden sm:inline">
                    <span class="text-gradient">treino sob medida</span>
                </h1>

                <p class="text-base sm:text-lg text-blue-100/80 mb-8 max-w-2xl mx-auto leading-relaxed"
                   data-aos="fade-up" data-aos-delay="200">
                    Atendimento <span class="text-white font-semibold">individual ou em dupla</span>, com correção técnica em tempo real.
                    1 hora de aula focada, sem turma cheia, sem treino genérico.
                </p>

                <div class="flex flex-col sm:flex-row gap-3 justify-center items-center px-4"
                     data-aos="fade-up" data-aos-delay="300">
                    @if($config && $config->whatsapp)
                        <a href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}?text=Olá! Gostaria de saber mais sobre as aulas"
                           target="_blank"
                           data-analytics="clique_whatsapp" data-analytics-nome="hero-fale-conosco"
                           class="btn-primary btn-shine inline-flex items-center justify-center gap-2 px-6 py-3 rounded-md text-sm sm:text-base font-semibold w-full sm:w-auto">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/></svg>
                            Fale conosco
                        </a>
                    @endif
                    <a href="#sobre" class="btn-ghost inline-flex items-center justify-center gap-2 px-6 py-3 rounded-md text-sm sm:text-base font-semibold w-full sm:w-auto">
                        Saiba mais
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        </svg>
                    </a>
                </div>

                {{-- Stats horizontais com divisão sutil --}}
                <div class="mt-12 sm:mt-14 grid grid-cols-2 gap-px bg-white/5 max-w-sm mx-auto rounded-xl overflow-hidden glass"
                     data-aos="fade-up" data-aos-delay="400">
                    <div class="px-3 py-3 text-center bg-gray-950/60">
                        <div class="text-xl sm:text-2xl font-bold text-white">@if($professor){{ $professor->anos_boxe }}+@else 10+ @endif</div>
                        <div class="text-[10px] text-gray-400 uppercase tracking-wider mt-0.5">Anos de boxe</div>
                    </div>
                    <div class="px-3 py-3 text-center bg-gray-950/60">
                        <div class="text-xl sm:text-2xl font-bold text-white">1h</div>
                        <div class="text-[10px] text-gray-400 uppercase tracking-wider mt-0.5">Por aula</div>
                    </div>
                </div>
            </div>
        </div>



        <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-gray-950 to-transparent pointer-events-none"></div>
    </section>

    {{-- ============================== SOBRE ============================== --}}
    <section id="sobre" class="relative py-16 md:py-24 bg-gray-950 overflow-hidden">
        <div class="blob blob-blue w-[500px] h-[500px] top-0 -right-32 opacity-20"></div>
        <div class="grid-pattern"></div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center max-w-2xl mx-auto mb-12" data-aos="fade-up">
                <span class="section-eyebrow">Sobre as aulas</span>
                <h2 class="font-display text-2xl md:text-3xl font-bold mt-4 mb-4">
                    <span class="text-white">Por que treinar </span><span class="text-gradient">de forma individual</span>
                </h2>
                <p class="text-sm md:text-base text-gray-400 leading-relaxed">
                    O atendimento é direto, sem disputa de atenção e sem treino padronizado.
                    Cada movimento é corrigido na hora, no seu ritmo.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-5">
                @php
                    $pilares = [
                        [
                            'titulo' => 'Apenas 1 ou 2 por vez',
                            'texto'  => 'Aulas no formato personal: atendimento individual ou em dupla. Sem turma cheia, sem fila pra usar o saco.',
                            'svg'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>',
                        ],
                        [
                            'titulo' => 'Correção em tempo real',
                            'texto'  => 'Toda postura, guarda e deslocamento corrigidos no momento. Você sai da aula sabendo exatamente o que ajustar.',
                            'svg'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>',
                        ],
                        [
                            'titulo' => 'Treino feito pra você',
                            'texto'  => 'Plano sob medida levando em conta seu nível, condicionamento e objetivo. Iniciante ou avançado, o treino acompanha.',
                            'svg'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>',
                        ],
                    ];
                @endphp

                @foreach($pilares as $i => $p)
                    <div class="gradient-border card-tilt p-6" data-aos="fade-up" data-aos-delay="{{ 80 + $i * 80 }}">
                        <span class="icon-tile mb-4" style="width:44px;height:44px;border-radius:12px;">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $p['svg'] !!}</svg>
                        </span>
                        <h3 class="text-base font-semibold text-white mb-2">{{ $p['titulo'] }}</h3>
                        <p class="text-sm text-gray-400 leading-relaxed">{{ $p['texto'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================== BENEFÍCIOS ============================== --}}
    <section id="beneficios" class="relative py-16 md:py-24 bg-gradient-section overflow-hidden">
        <div class="blob blob-cyan w-[500px] h-[500px] -bottom-32 -left-32 opacity-30"></div>
        <div class="blob blob-blue w-[400px] h-[400px] top-1/3 -right-32 opacity-20"></div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center max-w-2xl mx-auto mb-12" data-aos="fade-up">
                <span class="section-eyebrow">Resultado</span>
                <h2 class="font-display text-2xl md:text-3xl font-bold mt-4 mb-4">
                    <span class="text-white">O que você</span> <span class="text-gradient">leva pra vida</span>
                </h2>
                <p class="text-sm md:text-base text-gray-400">Vai muito além do soco. É mudança física e mental.</p>
            </div>

            @php
                $beneficios = [
                    ['icon'=>'🔥','titulo'=>'Condicionamento',     'desc'=>'Fôlego e força que você sente no dia a dia.'],
                    ['icon'=>'⚡','titulo'=>'Coordenação',          'desc'=>'Reflexos mais rápidos e movimentos precisos.'],
                    ['icon'=>'💎','titulo'=>'Confiança',            'desc'=>'Postura e segurança que se refletem em tudo.'],
                    ['icon'=>'🎯','titulo'=>'Disciplina',           'desc'=>'Constância e foco que viram hábito.'],
                    ['icon'=>'📈','titulo'=>'Evolução visível',     'desc'=>'Você sente o progresso aula após aula.'],
                    ['icon'=>'👁️','titulo'=>'Atenção exclusiva',    'desc'=>'Ninguém treina nas costas. É tudo pra você.'],
                ];
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 md:gap-4">
                @foreach($beneficios as $i => $b)
                    <div class="gradient-border card-tilt p-4 md:p-5 group" data-aos="fade-up" data-aos-delay="{{ 60 + $i * 50 }}">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-9 h-9 md:w-10 md:h-10 shrink-0 rounded-lg bg-blue-500/15 border border-blue-500/30 flex items-center justify-center text-lg md:text-xl transition-transform duration-500 group-hover:scale-110 group-hover:rotate-6">
                                {{ $b['icon'] }}
                            </div>
                            <h3 class="text-sm md:text-base font-semibold text-white leading-snug">{{ $b['titulo'] }}</h3>
                        </div>
                        <p class="text-gray-400 text-xs md:text-sm leading-relaxed">{{ $b['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================== INSTRUTOR ============================== --}}
    <section id="instrutor" class="relative py-16 md:py-24 bg-gray-950 overflow-hidden">
        <div class="blob blob-blue w-[600px] h-[600px] top-1/4 -left-40 opacity-15"></div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center max-w-2xl mx-auto mb-12" data-aos="fade-up">
                <span class="section-eyebrow">Instrutor</span>
                <h2 class="font-display text-2xl md:text-3xl font-bold mt-4 mb-3">
                    <span class="text-white">Quem vai</span> <span class="text-gradient">treinar você</span>
                </h2>
            </div>

            <div class="max-w-4xl mx-auto">
                @if($professor)
                    @php $imagensProfessor = json_decode($professor->imagens_professor ?? '[]', true); @endphp
                    <div class="grid md:grid-cols-2 gap-8 items-center">

                        {{-- Foto / slider --}}
                        <div class="order-2 md:order-1 w-full" data-aos="fade-right" data-aos-delay="100">
                            <div class="relative">
                                <div class="absolute -inset-2 bg-linear-to-tr from-blue-600/30 via-cyan-500/10 to-transparent rounded-2xl blur-xl opacity-60"></div>

                                @if(!empty($imagensProfessor))
                                    <div class="relative slider-container shadow-2xl">
                                        @foreach($imagensProfessor as $indice => $imagem)
                                            <div class="slide">
                                                <img src="{{ asset($imagem) }}" alt="{{ $professor->name }}" class="w-full h-full object-cover">
                                                <div class="absolute inset-0 bg-linear-to-t from-black/60 via-transparent to-transparent"></div>
                                            </div>
                                        @endforeach
                                        @if(count($imagensProfessor) > 1)
                                            <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2">
                                                @foreach($imagensProfessor as $indice => $imagem)
                                                    <button class="slider-indicator {{ $indice === 0 ? 'bg-blue-400 w-5' : 'bg-white/50' }}" data-slide="{{ $indice }}"></button>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="relative slider-container glass flex items-center justify-center">
                                        <div class="text-center text-gray-500 text-sm">
                                            <svg class="w-14 h-14 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            <p>Foto em breve</p>
                                        </div>
                                    </div>
                                @endif

                                {{-- Badge flutuante --}}
                                <div class="absolute -bottom-3 -right-3 glass-strong rounded-lg px-3 py-2 shadow-xl animate-float-medium z-10">
                                    <div class="text-[9px] uppercase tracking-wider text-blue-300">Experiência</div>
                                    <div class="text-base font-bold text-white leading-none">{{ $professor->anos_boxe }} {{ $professor->anos_boxe == 1 ? 'ano' : 'anos' }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- Informações --}}
                        <div class="order-1 md:order-2" data-aos="fade-left" data-aos-delay="200">
                            <div class="space-y-5">
                                <div>
                                    <div class="text-[11px] uppercase tracking-wider text-blue-400 font-semibold mb-1">Instrutor</div>
                                    <h3 class="font-display text-2xl md:text-3xl font-bold text-white">{{ $professor->name }}</h3>
                                </div>

                                <div class="space-y-2.5">
                                    <div class="flex items-center gap-3 glass rounded-lg p-3">
                                        <div class="w-9 h-9 rounded-md bg-linear-to-br from-blue-600 to-cyan-500 flex items-center justify-center shrink-0">
                                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-white font-semibold text-sm">{{ $professor->anos_boxe }} {{ $professor->anos_boxe == 1 ? 'ano' : 'anos' }} no boxe</p>
                                            <p class="text-gray-400 text-xs">Base sólida na arte marcial</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3 glass rounded-lg p-3">
                                        <div class="w-9 h-9 rounded-md bg-linear-to-br from-blue-600 to-cyan-500 flex items-center justify-center shrink-0">
                                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-white font-semibold text-sm">{{ $professor->anos_instrutor }} {{ $professor->anos_instrutor == 1 ? 'ano' : 'anos' }} dando aula</p>
                                            <p class="text-gray-400 text-xs">Sabe explicar e corrigir</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3 glass rounded-lg p-3">
                                        <div class="w-9 h-9 rounded-md bg-linear-to-br from-blue-600 to-cyan-500 flex items-center justify-center shrink-0">
                                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-white font-semibold text-sm">Plano individual</p>
                                            <p class="text-gray-400 text-xs">Cada aluno tem seu caminho</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="relative glass-strong rounded-lg p-4 border-l-2 border-blue-500">
                                    <span class="quote-mark absolute -top-2 left-2">"</span>
                                    <p class="text-gray-200 italic text-sm pl-5 leading-relaxed">{{ $professor->descricao_professor }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center glass-strong rounded-xl p-8">
                        <p class="text-gray-400 text-sm">Informações sobre o instrutor em breve.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ============================== VÍDEO DE APRESENTAÇÃO ============================== --}}
    @if($config && $config->video_apresentacao)
    <section id="apresentacao" class="relative py-16 md:py-24 bg-gradient-section overflow-hidden">
        <div class="blob blob-blue w-[500px] h-[500px] top-1/4 left-1/3 opacity-20 animate-mesh-shift"></div>
        <div class="blob blob-cyan w-[400px] h-[400px] bottom-0 right-1/4 opacity-20 animate-mesh-shift" style="animation-delay:-8s;"></div>
        <div class="grid-pattern"></div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center max-w-2xl mx-auto mb-10" data-aos="fade-up">
                <span class="section-eyebrow">Conheça</span>
                <h2 class="font-display text-2xl md:text-3xl font-bold mt-4 mb-3">
                    <span class="text-white">Aperte o</span> <span class="text-gradient">play</span>
                </h2>
                <p class="text-sm md:text-base text-gray-400">Veja o ambiente e como é uma aula aqui.</p>
            </div>

            <div class="flex justify-center" data-aos="zoom-in" data-aos-delay="100">
                <div class="relative group">
                    <div class="absolute -inset-4 bg-linear-to-r from-blue-600 via-cyan-500 to-blue-600 rounded-2xl blur-xl opacity-30 group-hover:opacity-50 transition-opacity duration-500 animate-gradient-x"></div>

                    <div class="relative bg-gray-900 rounded-xl overflow-hidden border border-white/10 shadow-2xl" style="width: 300px; max-width: 90vw;">
                        <video id="videoApresentacao"
                               class="w-full object-cover cursor-pointer block"
                               style="aspect-ratio: 9/16;"
                               playsinline preload="metadata"
                               onclick="toggleVideoApresentacao(this)">
                            <source src="{{ asset($config->video_apresentacao) }}" type="video/mp4">
                            Seu navegador não suporta vídeo.
                        </video>

                        <div id="videoPlayOverlay" class="absolute inset-0 flex items-center justify-center bg-black/30 transition-opacity duration-300 cursor-pointer" onclick="toggleVideoApresentacao(document.getElementById('videoApresentacao'))">
                            <div class="w-16 h-16 bg-white/15 backdrop-blur-md rounded-full flex items-center justify-center border-2 border-white/50 hover:bg-white/25 hover:scale-110 transition-all duration-300 animate-pulse-glow">
                                <svg class="w-7 h-7 text-white ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ============================== AVALIAÇÕES ============================== --}}
    @if($avaliacoes->isNotEmpty())
    <section id="avaliacoes" class="relative py-16 md:py-24 bg-gray-950 overflow-hidden">
        <div class="blob blob-violet w-[500px] h-[500px] -top-32 left-1/4 opacity-20"></div>
        <div class="blob blob-blue w-[500px] h-[500px] bottom-0 right-0 opacity-20"></div>
        <div class="grid-pattern"></div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center max-w-2xl mx-auto mb-12" data-aos="fade-up">
                <span class="section-eyebrow">Depoimentos</span>
                <h2 class="font-display text-2xl md:text-3xl font-bold mt-4 mb-3">
                    <span class="text-white">O que dizem os</span> <span class="text-gradient">alunos</span>
                </h2>
                <p class="text-sm md:text-base text-gray-400">Quem treina aqui não fica em segredo.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($avaliacoes as $i => $avaliacao)
                    <div class="gradient-border card-tilt p-5 relative" data-aos="fade-up" data-aos-delay="{{ 60 + $i * 60 }}">
                        <span class="quote-mark absolute -top-1 left-3">"</span>
                        <div class="flex items-center gap-3 mb-4 mt-1">
                            @if($avaliacao->foto_avaliacao)
                                <img src="{{ asset($avaliacao->foto_avaliacao) }}" alt="Foto" class="w-10 h-10 rounded-full object-cover border-2 border-blue-400/50">
                            @else
                                <div class="avatar-initial w-10 h-10 rounded-full flex items-center justify-center text-sm">
                                    {{ mb_strtoupper(mb_substr($avaliacao->nome_exibicao ?: '?', 0, 1)) }}
                                </div>
                            @endif
                            <div class="min-w-0">
                                <h3 class="text-white font-semibold text-sm truncate">{{ $avaliacao->nome_exibicao }}</h3>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <div class="text-yellow-400 text-[11px] tracking-wider">★★★★★</div>
                                    <span class="text-gray-500 text-[11px]">· {{ $avaliacao->user ? 'Aluno' : 'Visitante' }}</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-300 italic text-sm leading-relaxed">{{ $avaliacao->comentario }}</p>
                        <div class="mt-4 pt-3 border-t border-white/5">
                            <p class="text-gray-500 text-[11px]">{{ \Carbon\Carbon::parse($avaliacao->created_at)->locale('pt_BR')->isoFormat('MMMM [de] YYYY') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ============================== GALERIA ============================== --}}
    @if($fotosCentro->isNotEmpty())
    <section id="galeria" class="relative py-16 md:py-24 bg-gradient-section overflow-hidden">
        <div class="blob blob-cyan w-[500px] h-[500px] top-0 -left-32 opacity-25"></div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center max-w-2xl mx-auto mb-10" data-aos="fade-up">
                <span class="section-eyebrow">Espaço</span>
                <h2 class="font-display text-2xl md:text-3xl font-bold mt-4 mb-3">
                    <span class="text-white">Conheça o</span> <span class="text-gradient">centro de treinamento</span>
                </h2>
                <p class="text-sm md:text-base text-gray-400">Ambiente fechado, organizado e equipado.</p>
            </div>

            {{-- Grid uniforme — todas as fotos no mesmo tamanho (aspect-square no mobile, 4:3 em desktop) --}}
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4">
                @foreach($fotosCentro->take(6) as $i => $foto)
                    <button type="button"
                            class="group relative aspect-[4/3] overflow-hidden rounded-lg cursor-pointer shadow-lg hover-lift bg-gray-900"
                            data-aos="fade-up" data-aos-delay="{{ 40 + $i * 50 }}"
                            onclick="openPhotoModal('{{ asset($foto->caminho_arquivo) }}', '{{ addslashes($foto->descricao ?: 'Foto do centro de treinamento') }}')">
                        <img src="{{ asset($foto->caminho_arquivo) }}"
                             alt="{{ $foto->descricao ?: 'Foto do centro de treinamento' }}"
                             class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-linear-to-t from-black/70 via-black/10 to-transparent"></div>
                        @if($foto->descricao)
                            <div class="absolute bottom-0 left-0 right-0 p-3 text-left">
                                <p class="text-white text-xs md:text-sm font-semibold truncate">{{ $foto->descricao }}</p>
                            </div>
                        @endif
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="bg-white/15 backdrop-blur-md rounded-full p-2.5 border border-white/30">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ============================== HORÁRIOS ============================== --}}
    @if($horarios->isNotEmpty())
    <section id="horarios" class="relative py-16 md:py-24 bg-gray-950 overflow-hidden">
        <div class="blob blob-blue w-[500px] h-[500px] -bottom-32 left-1/4 opacity-20"></div>
        <div class="grid-pattern"></div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center max-w-2xl mx-auto mb-10" data-aos="fade-up">
                <span class="section-eyebrow">Agenda</span>
                <h2 class="font-display text-2xl md:text-3xl font-bold mt-4 mb-3">
                    <span class="text-white">Encaixe na</span> <span class="text-gradient">sua rotina</span>
                </h2>
                <p class="text-sm md:text-base text-gray-400">Cada aula tem 1 hora de duração.</p>
            </div>

            @php
                $diasSemana = [
                    1 => 'Segunda', 2 => 'Terça', 3 => 'Quarta',
                    4 => 'Quinta',  5 => 'Sexta', 6 => 'Sábado', 7 => 'Domingo',
                ];
                $diasAbrev = [
                    1 => 'SEG', 2 => 'TER', 3 => 'QUA',
                    4 => 'QUI', 5 => 'SEX', 6 => 'SÁB', 7 => 'DOM',
                ];
                $hojeIso = (int) \Carbon\Carbon::now()->dayOfWeekIso;
            @endphp

            {{-- Lista vertical sofisticada (mesma estrutura em mobile e desktop) --}}
            <div class="glass-strong rounded-xl overflow-hidden divide-y divide-white/5" data-aos="fade-up" data-aos-delay="100">
                @foreach($horarios as $diaNumero => $horariosDay)
                    @php $ehHoje = $hojeIso === (int) $diaNumero; @endphp
                    <div class="flex items-center gap-4 px-4 sm:px-6 py-4 {{ $ehHoje ? 'bg-blue-500/10' : '' }} transition-colors hover:bg-white/[0.03]">
                        {{-- Sigla do dia em destaque --}}
                        <div class="shrink-0 w-12 sm:w-14 text-center">
                            <div class="font-display text-xl sm:text-2xl font-bold {{ $ehHoje ? 'text-gradient-blue' : 'text-white' }} leading-none">
                                {{ $diasAbrev[$diaNumero] ?? '?' }}
                            </div>
                            @if($ehHoje)
                                <div class="text-[9px] font-semibold uppercase tracking-wider text-blue-400 mt-1">Hoje</div>
                            @endif
                        </div>
                        {{-- Linha vertical separadora --}}
                        <div class="w-px h-10 bg-white/10 shrink-0"></div>
                        {{-- Nome completo do dia + horários em badges --}}
                        <div class="flex-1 min-w-0">
                            <div class="text-xs uppercase tracking-wider text-gray-500 mb-1.5">
                                {{ ($diasSemana[$diaNumero] ?? 'Dia '.$diaNumero) . (in_array($diaNumero, [6, 7]) ? '' : '-feira') }}
                            </div>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($horariosDay as $horario)
                                    @php
                                        $inicio = \Carbon\Carbon::parse($horario->hora_inicio);
                                        $fim    = $inicio->copy()->addMinutes(60);
                                    @endphp
                                    <span class="whitespace-nowrap text-xs font-medium px-2.5 py-1 rounded-full bg-blue-500/15 border border-blue-500/30 text-blue-200">
                                        {{ $inicio->format('H:i') }} – {{ $fim->format('H:i') }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Nota inferior --}}
            <p class="text-center text-xs text-gray-500 mt-4">
                Atendimento individual ou em dupla. Confirme disponibilidade pelo WhatsApp.
            </p>
        </div>
    </section>
    @endif

    {{-- ============================== SISTEMA DO ALUNO ============================== --}}
    <section id="sistema" class="relative py-16 md:py-24 bg-gradient-section overflow-hidden">
        <div class="blob blob-blue w-[500px] h-[500px] top-1/4 -right-32 opacity-20"></div>
        <div class="blob blob-cyan w-[400px] h-[400px] -bottom-20 left-1/4 opacity-20"></div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center max-w-2xl mx-auto mb-12" data-aos="fade-up">
                <span class="section-eyebrow">Tecnologia</span>
                <h2 class="font-display text-2xl md:text-3xl font-bold mt-4 mb-3">
                    <span class="text-white">{{ $sistemaAluno->titulo ?? 'Sistema do' }}</span>
                    @if(!str_contains(strtolower($sistemaAluno->titulo ?? ''), 'aluno'))
                        <span class="text-gradient">aluno</span>
                    @endif
                </h2>
                <p class="text-sm md:text-base text-gray-400">
                    {{ $sistemaAluno->descricao ?? 'Acompanhe sua evolução, aulas e tudo num só lugar.' }}
                </p>
            </div>

            @php $temImagens = $sistemaAluno && $sistemaAluno->imagens && count($sistemaAluno->imagens) > 0; @endphp

            <div class="grid lg:grid-cols-5 gap-5 max-w-6xl mx-auto">
                {{-- Imagens slider 16:9 (Full HD) --}}
                @if($temImagens)
                    <div class="lg:col-span-3 order-1" data-aos="fade-right" data-aos-delay="100">
                        <div class="relative">
                            <div class="absolute -inset-2 bg-linear-to-r from-blue-600/30 via-cyan-500/20 to-transparent rounded-2xl blur-xl opacity-50"></div>
                            <div class="relative sistema-slider-container shadow-2xl border border-white/10">
                                @foreach($sistemaAluno->imagens as $indice => $imagem)
                                    <div class="sistema-slide">
                                        <img src="{{ asset($imagem) }}" alt="Sistema do aluno - tela {{ $indice + 1 }}">
                                    </div>
                                @endforeach
                                @if(count($sistemaAluno->imagens) > 1)
                                    <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                                        @foreach($sistemaAluno->imagens as $indice => $imagem)
                                            <button class="sistema-slider-indicator {{ $indice === 0 ? 'bg-blue-400 w-5' : 'bg-white/50' }}" data-slide="{{ $indice }}"></button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Resumo + Detalhes --}}
                <div class="{{ $temImagens ? 'lg:col-span-2' : 'lg:col-span-5' }} order-2 space-y-4">
                    <div class="gradient-border p-5" data-aos="fade-left" data-aos-delay="200">
                        <div class="flex items-center gap-2.5 mb-3">
                            <span class="icon-tile" style="width:36px;height:36px;border-radius:10px;">
                                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </span>
                            <h3 class="text-sm font-semibold text-white">O que você acompanha</h3>
                        </div>
                        <ul class="space-y-1.5 text-gray-300">
                            @if($sistemaAluno && $sistemaAluno->resumo_items)
                                @foreach($sistemaAluno->resumo_items as $item)
                                    <li class="flex items-start gap-2 text-xs sm:text-sm">
                                        <svg class="w-3.5 h-3.5 text-blue-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        <span>{{ $item }}</span>
                                    </li>
                                @endforeach
                            @else
                                <li class="flex items-start gap-2 text-xs sm:text-sm">
                                    <svg class="w-3.5 h-3.5 text-blue-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    <span>Sua evolução em tempo real</span>
                                </li>
                                <li class="flex items-start gap-2 text-xs sm:text-sm">
                                    <svg class="w-3.5 h-3.5 text-blue-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    <span>Aulas registradas e sequência aprendida</span>
                                </li>
                                <li class="flex items-start gap-2 text-xs sm:text-sm">
                                    <svg class="w-3.5 h-3.5 text-blue-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    <span>Saldo de aulas e horários</span>
                                </li>
                            @endif
                        </ul>
                    </div>

                    @if($sistemaAluno && $sistemaAluno->detalhes)
                        <div class="gradient-border p-5" data-aos="fade-left" data-aos-delay="250">
                            <p class="text-gray-300 text-xs sm:text-sm leading-relaxed">{{ $sistemaAluno->detalhes }}</p>
                        </div>
                    @endif

                    <a href="{{ route('login') }}" data-analytics="clique_login" data-analytics-nome="sistema-aluno"
                       class="btn-blue btn-shine inline-flex items-center justify-center gap-2 w-full px-5 py-3 rounded-md text-sm font-semibold"
                       data-aos="fade-left" data-aos-delay="300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Acessar minha área
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================== LOCALIZAÇÃO ============================== --}}
    @if($config && $config->maps_src)
    <section id="localizacao" class="relative py-16 md:py-24 bg-gray-950 overflow-hidden">
        <div class="blob blob-blue w-[500px] h-[500px] top-1/3 right-0 opacity-15"></div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center max-w-2xl mx-auto mb-10" data-aos="fade-up">
                <span class="section-eyebrow">Localização</span>
                <h2 class="font-display text-2xl md:text-3xl font-bold mt-4 mb-3">
                    <span class="text-white">Onde a gente</span> <span class="text-gradient">treina</span>
                </h2>
                <p class="text-sm md:text-base text-gray-400">Espaço fechado e equipado, longe da correria da rua.</p>
            </div>

            <div class="relative" data-aos="fade-up" data-aos-delay="100">
                <div class="absolute -inset-3 bg-linear-to-r from-blue-600/30 via-cyan-500/20 to-blue-600/30 rounded-2xl blur-xl opacity-40"></div>

                <div class="relative glass-strong rounded-xl overflow-hidden border border-white/10">
                    <iframe src="{{ $config->maps_src }}"
                            width="100%" height="420"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            class="w-full block">
                    </iframe>

                    <div class="absolute bottom-3 left-3 right-3 sm:right-auto sm:max-w-sm glass-strong rounded-lg p-3 border border-white/10 shadow-2xl">
                        <div class="flex items-start gap-2.5">
                            <div class="w-9 h-9 rounded-md bg-linear-to-br from-red-500 to-orange-500 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <div class="text-white font-semibold text-sm">Boxing House PF</div>
                                <div class="text-gray-400 text-xs leading-snug mt-0.5">
                                    @if($config && ($config->bairro || $config->cidade))
                                        {{ $config->bairro ? $config->bairro.' · ' : '' }}{{ $config->cidade ?: 'Passo Fundo' }}, RS
                                        @if($config->rua && $config->numero)
                                            <br>{{ $config->rua }}, {{ $config->numero }}
                                        @elseif($config->rua)
                                            <br>{{ $config->rua }}
                                        @endif
                                    @else
                                        Passo Fundo, RS
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ============================== CONTATO ============================== --}}
    <section id="contato" class="relative py-16 md:py-24 bg-gradient-section overflow-hidden">
        <div class="blob blob-blue w-[500px] h-[500px] top-0 right-1/4 opacity-20"></div>
        <div class="blob blob-cyan w-[400px] h-[400px] bottom-0 left-1/4 opacity-20"></div>
        <div class="grid-pattern"></div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center max-w-2xl mx-auto mb-10" data-aos="fade-up">
                <span class="section-eyebrow">Contato</span>
                <h2 class="font-display text-2xl md:text-3xl font-bold mt-4 mb-3">
                    <span class="text-white">Bora</span> <span class="text-gradient">conversar?</span>
                </h2>
                <p class="text-sm md:text-base text-gray-400">Pergunte qualquer coisa ou agende uma visita.</p>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3" data-aos="fade-up" data-aos-delay="100">
                @if($config && $config->whatsapp)
                    <a href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}" target="_blank"
                       data-analytics="clique_whatsapp" data-analytics-nome="contato-numero"
                       class="gradient-border card-tilt p-4 text-center block group">
                        <div class="w-10 h-10 rounded-lg bg-linear-to-br from-green-500 to-emerald-500 flex items-center justify-center mx-auto mb-2.5 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/></svg>
                        </div>
                        <div class="text-[10px] text-gray-500 uppercase tracking-wider mb-0.5">WhatsApp</div>
                        <div class="text-white font-medium text-xs truncate">{{ $config->whatsapp }}</div>
                    </a>
                @endif

                @if($config && $config->email)
                    <a href="mailto:{{ $config->email }}" class="gradient-border card-tilt p-4 text-center block group">
                        <div class="w-10 h-10 rounded-lg bg-linear-to-br from-blue-500 to-cyan-500 flex items-center justify-center mx-auto mb-2.5 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="text-[10px] text-gray-500 uppercase tracking-wider mb-0.5">E-mail</div>
                        <div class="text-white font-medium text-[11px] break-all leading-tight">{{ $config->email }}</div>
                    </a>
                @endif

                @if($config && $config->instagram)
                    <a href="https://instagram.com/{{ ltrim($config->instagram, '@') }}" target="_blank"
                       class="gradient-border card-tilt p-4 text-center block group">
                        <div class="w-10 h-10 rounded-lg bg-linear-to-br from-purple-500 via-pink-500 to-orange-400 flex items-center justify-center mx-auto mb-2.5 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </div>
                        <div class="text-[10px] text-gray-500 uppercase tracking-wider mb-0.5">Instagram</div>
                        <div class="text-white font-medium text-xs truncate">{{ $config->instagram }}</div>
                    </a>
                @endif

                <div class="gradient-border card-tilt p-4 text-center">
                    <div class="w-10 h-10 rounded-lg bg-linear-to-br from-red-500 to-orange-500 flex items-center justify-center mx-auto mb-2.5">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div class="text-[10px] text-gray-500 uppercase tracking-wider mb-0.5">Endereço</div>
                    <div class="text-white font-medium text-xs leading-tight">
                        @if($config && ($config->bairro || $config->cidade))
                            {{ $config->cidade ?: 'Passo Fundo' }}, RS
                        @else
                            Passo Fundo, RS
                        @endif
                    </div>
                </div>
            </div>

            @if($config && $config->whatsapp)
                <div class="mt-8 text-center" data-aos="fade-up" data-aos-delay="200">
                    <a href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}?text=Olá! Gostaria de conhecer a Boxing House PF"
                       target="_blank"
                       data-analytics="clique_whatsapp" data-analytics-nome="contato-fale-conosco"
                       class="btn-primary btn-shine inline-flex items-center justify-center gap-2 px-7 py-3 rounded-md text-sm sm:text-base font-semibold">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/></svg>
                        Falar agora no WhatsApp
                    </a>
                </div>
            @endif
        </div>
    </section>

    {{-- ============================== CTA FINAL ============================== --}}
    <section class="relative py-20 md:py-28 overflow-hidden bg-linear-to-br from-blue-900 via-blue-700 to-cyan-600 animate-gradient-x">
        <div class="blob blob-cyan w-[600px] h-[600px] -top-32 -left-32 opacity-50 animate-mesh-shift"></div>
        <div class="blob blob-violet w-[500px] h-[500px] -bottom-32 -right-32 opacity-40 animate-mesh-shift" style="animation-delay: -10s;"></div>
        <div class="grid-pattern"></div>
        <div class="noise-overlay"></div>

        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div data-aos="fade-up">
                <span class="section-eyebrow" style="background: rgba(255,255,255,0.12); border-color: rgba(255,255,255,0.25); color: #fff;">Pronto pra começar?</span>
                <h2 class="font-display text-3xl md:text-4xl font-bold mt-5 mb-4 leading-tight">
                    Agende sua <span class="italic">aula experimental</span>
                </h2>
                <p class="text-sm md:text-base text-blue-50 mb-8 max-w-xl mx-auto">
                    Venha conhecer o espaço e sentir como é treinar em formato personal.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 justify-center px-4" data-aos="fade-up" data-aos-delay="200">
                @if($config && $config->whatsapp)
                    <a href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}?text=Olá! Gostaria de agendar uma aula experimental"
                       target="_blank"
                       data-analytics="clique_whatsapp" data-analytics-nome="cta-aula-experimental"
                       class="btn-primary btn-shine inline-flex items-center justify-center gap-2 px-6 py-3 rounded-md text-sm sm:text-base font-semibold w-full sm:w-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Agendar experimental
                    </a>
                @endif
                <a href="{{ route('login') }}"
                   data-analytics="clique_login" data-analytics-nome="cta-area-aluno"
                   class="btn-ghost inline-flex items-center justify-center gap-2 px-6 py-3 rounded-md text-sm sm:text-base font-semibold w-full sm:w-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Área do aluno
                </a>
            </div>
        </div>
    </section>

    {{-- ============================== FOOTER ============================== --}}
    <footer class="relative bg-gray-950 border-t border-white/5 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex justify-center mb-4">
                <img src="{{ asset('logo-y.png') }}" alt="Boxing House PF" class="h-12 w-auto">
            </div>
            <p class="text-gradient-blue font-display font-semibold text-base mb-4">Aulas personais de boxe</p>
            <div class="flex justify-center flex-wrap gap-x-5 gap-y-2 mb-5">
                @if($config && $config->whatsapp)
                    <a href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}" target="_blank"
                       data-analytics="clique_whatsapp" data-analytics-nome="footer"
                       class="text-gray-400 hover:text-green-400 transition-colors text-xs">WhatsApp</a>
                @endif
                @if($config && $config->email)
                    <a href="mailto:{{ $config->email }}" class="text-gray-400 hover:text-blue-400 transition-colors text-xs">E-mail</a>
                @endif
                @if($config && $config->instagram)
                    <a href="https://instagram.com/{{ ltrim($config->instagram, '@') }}" target="_blank" class="text-gray-400 hover:text-pink-400 transition-colors text-xs">Instagram</a>
                @endif
                <a href="{{ route('precos') }}" class="text-gray-400 hover:text-blue-400 transition-colors text-xs">Valores</a>
                <a href="{{ route('login') }}" class="text-gray-400 hover:text-blue-400 transition-colors text-xs">Área do aluno</a>
            </div>
            <p class="text-gray-500 text-[11px]">© {{ date('Y') }} Boxing House PF — Todos os direitos reservados.</p>
        </div>
    </footer>

    {{-- ============================== MODAL DE FOTOS ============================== --}}
    <div id="photoModal"
         class="fixed inset-0 bg-black/90 backdrop-blur-md z-[100] hidden p-3 sm:p-6 overflow-hidden"
         onclick="closePhotoModal()"
         role="dialog" aria-modal="true">
        <div class="relative w-full h-full flex items-center justify-center" onclick="event.stopPropagation()">
            {{-- Botão fechar fixo --}}
            <button onclick="closePhotoModal()"
                    class="absolute top-3 right-3 sm:top-4 sm:right-4 z-10 bg-black/60 hover:bg-black/80 text-white w-9 h-9 sm:w-10 sm:h-10 rounded-full flex items-center justify-center transition-colors border border-white/10">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            {{-- Container da imagem com tamanho controlado --}}
            <div class="relative max-w-full max-h-full flex flex-col items-center">
                <img id="modalPhoto" src="" alt=""
                     class="max-w-full max-h-[80vh] sm:max-h-[85vh] w-auto h-auto object-contain rounded-lg shadow-2xl">
                <p id="modalDescription"
                   class="mt-3 text-center text-white text-sm sm:text-base font-medium max-w-2xl px-3 hidden"></p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // ====================================================================
        // MODAL DE FOTOS — controla overflow e dimensões pra não estourar
        // ====================================================================
        function openPhotoModal(src, description) {
            const modal      = document.getElementById('photoModal');
            const modalPhoto = document.getElementById('modalPhoto');
            const modalDesc  = document.getElementById('modalDescription');
            modalPhoto.src  = src;
            modalPhoto.alt  = description || '';
            // Só mostra descrição se houver uma significativa
            if (description && description.trim().length && description !== 'Foto do centro de treinamento') {
                modalDesc.textContent = description;
                modalDesc.classList.remove('hidden');
            } else {
                modalDesc.classList.add('hidden');
            }
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
        function closePhotoModal() {
            const modal = document.getElementById('photoModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closePhotoModal(); });

        // ====================================================================
        // SMOOTH SCROLLING — desconta altura do header fixo
        // ====================================================================
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href === '#') return;
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    const offsetTop = target.getBoundingClientRect().top + window.scrollY - 64;
                    window.scrollTo({ top: offsetTop, behavior: 'smooth' });
                }
            });
        });

        // ====================================================================
        // HEADER: ajusta opacidade/borda conforme rolagem
        // ====================================================================
        const header = document.getElementById('site-header');
        function atualizarHeader() {
            if (window.scrollY > 60) {
                header.classList.add('bg-gray-950/85', 'border-white/10');
                header.classList.remove('bg-gray-950/40', 'border-white/5');
            } else {
                header.classList.remove('bg-gray-950/85', 'border-white/10');
                header.classList.add('bg-gray-950/40', 'border-white/5');
            }
        }
        window.addEventListener('scroll', atualizarHeader, { passive: true });
        atualizarHeader();

        // ====================================================================
        // SLIDER GENÉRICO — usado pelo slider do professor e do sistema
        // ====================================================================
        function inicializarSlider(containerSelector, slideSelector, indicatorSelector, intervaloMs) {
            const container = document.querySelector(containerSelector);
            if (!container) return;
            const slides     = container.querySelectorAll(slideSelector);
            const indicators = container.querySelectorAll(indicatorSelector);
            if (slides.length <= 1) return;

            let current = 0;
            let isTransitioning = false;

            slides.forEach((slide, i) => {
                slide.style.position = i === 0 ? 'relative' : 'absolute';
                slide.style.top = '0';
                slide.style.left = '0';
                slide.style.width = '100%';
                slide.style.height = '100%';
                slide.style.opacity = i === 0 ? '1' : '0';
            });

            function ir(idx) {
                if (isTransitioning || idx === current) return;
                isTransitioning = true;
                const atual = slides[current];
                const prox  = slides[idx];

                prox.style.position = 'absolute';
                prox.style.opacity  = '0';
                atual.style.opacity = '0';

                setTimeout(() => {
                    prox.style.opacity = '1';
                    setTimeout(() => {
                        atual.style.position = 'absolute';
                        prox.style.position  = 'relative';
                        indicators.forEach((ind, i) => {
                            if (i === idx) {
                                ind.classList.remove('bg-white/50'); ind.classList.add('bg-blue-400', 'w-5');
                            } else {
                                ind.classList.remove('bg-blue-400', 'w-5'); ind.classList.add('bg-white/50');
                            }
                        });
                        current = idx;
                        isTransitioning = false;
                    }, 1000);
                }, 50);
            }

            indicators.forEach((ind, i) => ind.addEventListener('click', () => ir(i)));
            setInterval(() => ir((current + 1) % slides.length), intervaloMs);
        }

        document.addEventListener('DOMContentLoaded', () => {
            inicializarSlider('.slider-container', '.slide', '.slider-indicator', 4500);
            inicializarSlider('.sistema-slider-container', '.sistema-slide', '.sistema-slider-indicator', 5500);
        });
    </script>

    {{-- Vídeo de apresentação --}}
    <script>
        function toggleVideoApresentacao(video) {
            const overlay = document.getElementById('videoPlayOverlay');
            if (!video || !overlay) return;
            if (video.paused) {
                video.play();
                overlay.style.opacity = '0';
                overlay.style.pointerEvents = 'none';
            } else {
                video.pause();
                overlay.style.opacity = '1';
                overlay.style.pointerEvents = 'auto';
            }
        }
        document.addEventListener('DOMContentLoaded', () => {
            const video = document.getElementById('videoApresentacao');
            if (video) {
                video.addEventListener('ended', () => {
                    const overlay = document.getElementById('videoPlayOverlay');
                    if (overlay) {
                        overlay.style.opacity = '1';
                        overlay.style.pointerEvents = 'auto';
                    }
                });
            }
        });
    </script>

    {{-- Analytics Tracking --}}
    <script>
        (function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            function registrarEvento(tipo, nome) {
                fetch('{{ route("analytics.registrar") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ tipo, nome })
                }).catch(() => {});
            }
            registrarEvento('visita', 'landing');
            document.addEventListener('click', (e) => {
                const el = e.target.closest('[data-analytics]');
                if (el) registrarEvento(el.getAttribute('data-analytics'), el.getAttribute('data-analytics-nome') || 'desconhecido');
            });
        })();
    </script>
@endsection
