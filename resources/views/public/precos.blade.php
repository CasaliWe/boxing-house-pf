@extends('layouts.landing')

@section('title', 'Valores - Boxing House PF')
@section('description', 'Conheça os valores por aula da Boxing House PF. Escolha quantas aulas quer no mês e veja o valor por aula.')
@section('keywords', 'valores boxe, preços boxe, aula experimental boxe, boxing house pf')

@section('og_title', 'Valores - Boxing House PF')
@section('og_description', 'Conheça os valores por aula da Boxing House PF.')

@section('content')
    {{-- Cabeçalho fixo da página pública --}}
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
                           class="bg-green-600 hover:bg-green-700 px-3 py-2 md:px-4 md:py-2 rounded-lg text-xs md:text-sm font-medium transition-colors">
                            WhatsApp
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <section class="pt-32 pb-20 bg-gradient-section min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Título principal explicando a lógica em uma frase --}}
            <div class="text-center mb-12" data-aos="fade-up">
                <h1 class="text-3xl md:text-5xl font-bold text-blue-400 mb-6">Como funcionam os valores</h1>
                <p class="text-lg md:text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
                    Você escolhe <span class="text-white font-semibold">quantas aulas</span> quer fazer no mês.
                    Pode ser <span class="text-white font-semibold">2, 5, 7, 10</span>… o número que preferir.
                    <br class="hidden md:block">
                    O <span class="text-white font-semibold">valor por aula</span> diminui conforme você treina mais vezes.
                </p>
            </div>

            @if($valores->isNotEmpty())
                {{-- Faixas de valores: tabela visual simplificada --}}
                <div class="max-w-5xl mx-auto mb-16" data-aos="fade-up" data-aos-delay="100">
                    <div class="grid grid-cols-1 md:grid-cols-{{ min($valores->count(), 3) }} gap-4 md:gap-6">
                        @foreach($valores as $valor)
                            @php
                                // Define a faixa anterior para mostrar o intervalo (ex: "De 5 até 8 aulas")
                                $faixaAnterior = $loop->index > 0 ? $valores[$loop->index - 1]->aulas_mes + 1 : 1;
                            @endphp
                            <div class="bg-gray-900 border-2 border-gray-700 rounded-2xl p-6 md:p-8 text-center hover:border-blue-500 transition-all duration-300">
                                {{-- Selo com o intervalo de aulas --}}
                                <div class="inline-block bg-blue-600/20 text-blue-400 text-xs md:text-sm font-semibold px-3 py-1 rounded-full mb-4">
                                    @if($faixaAnterior === $valor->aulas_mes)
                                        {{ $valor->aulas_mes }} {{ $valor->aulas_mes == 1 ? 'aula' : 'aulas' }} no mês
                                    @else
                                        De {{ $faixaAnterior }} até {{ $valor->aulas_mes }} aulas no mês
                                    @endif
                                </div>

                                {{-- Valor por aula em destaque --}}
                                <div class="text-4xl md:text-5xl font-bold text-white mb-1">
                                    R$ {{ number_format($valor->valor_aula, 2, ',', '.') }}
                                </div>
                                <div class="text-gray-400 text-sm">por aula</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Calculadora interativa para o aluno simular o valor --}}
                <div class="max-w-3xl mx-auto mb-16" data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-linear-to-br from-blue-900/40 to-gray-900 border-2 border-blue-600 rounded-2xl p-6 md:p-10">
                        <div class="text-center mb-6">
                            <h2 class="text-2xl md:text-3xl font-bold text-white mb-2">Faça sua simulação</h2>
                            <p class="text-gray-300">Quantas aulas você quer fazer por mês?</p>
                        </div>

                        {{-- Controles: botões -/+ e número grande no meio --}}
                        <div class="flex items-center justify-center gap-4 md:gap-6 mb-8">
                            <button type="button" id="btn-diminuir"
                                    class="w-14 h-14 md:w-16 md:h-16 rounded-full bg-gray-800 hover:bg-gray-700 border-2 border-gray-600 text-white text-3xl font-bold transition-colors flex items-center justify-center"
                                    aria-label="Diminuir aulas">
                                −
                            </button>

                            <div class="text-center min-w-30">
                                <div id="qtd-aulas" class="text-6xl md:text-7xl font-bold text-blue-400 leading-none">4</div>
                                <div class="text-gray-400 text-sm mt-1">aulas / mês</div>
                            </div>

                            <button type="button" id="btn-aumentar"
                                    class="w-14 h-14 md:w-16 md:h-16 rounded-full bg-gray-800 hover:bg-gray-700 border-2 border-gray-600 text-white text-3xl font-bold transition-colors flex items-center justify-center"
                                    aria-label="Aumentar aulas">
                                +
                            </button>
                        </div>

                        {{-- Resultado da simulação --}}
                        <div class="bg-gray-900/60 rounded-xl p-6 text-center">
                            <div class="flex flex-col md:flex-row md:justify-around gap-4 md:gap-2">
                                <div>
                                    <div class="text-xs text-gray-400 uppercase tracking-wider mb-1">Valor por aula</div>
                                    <div id="valor-aula" class="text-2xl md:text-3xl font-bold text-white">R$ 40,00</div>
                                </div>
                                <div class="hidden md:block w-px bg-gray-700"></div>
                                <div>
                                    <div class="text-xs text-gray-400 uppercase tracking-wider mb-1">Total no mês</div>
                                    <div id="valor-total" class="text-2xl md:text-3xl font-bold text-blue-400">R$ 160,00</div>
                                </div>
                            </div>
                        </div>

                        {{-- Botão de contato com o valor pré-preenchido --}}
                        @if($config && $config->whatsapp)
                            <div class="mt-6 text-center">
                                <a id="link-whatsapp"
                                   href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}"
                                   target="_blank"
                                   class="inline-flex items-center justify-center bg-green-600 hover:bg-green-700 px-8 py-4 rounded-lg font-semibold text-white transition-colors w-full md:w-auto">
                                    Finalizar no WhatsApp
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="text-center py-20">
                    <p class="text-xl text-gray-300">Nenhum valor cadastrado no momento.</p>
                </div>
            @endif

            {{-- Aula experimental destacada separadamente --}}
            @if($valorExperimental)
                <div class="max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="300">
                    <div class="bg-gray-900 border border-gray-700 rounded-2xl p-6 md:p-8 flex flex-col md:flex-row items-center md:justify-between gap-6">
                        <div class="text-center md:text-left">
                            <div class="text-xs text-blue-400 uppercase tracking-wider font-semibold mb-2">Primeira vez aqui?</div>
                            <h3 class="text-2xl font-bold text-white mb-1">Aula experimental</h3>
                            <p class="text-gray-400">Conheça a academia antes de fechar qualquer pacote.</p>
                        </div>
                        <div class="text-center md:text-right">
                            <div class="text-3xl md:text-4xl font-bold text-blue-400 mb-3">
                                R$ {{ number_format($valorExperimental->valor_aula, 2, ',', '.') }}
                            </div>
                            <a href="{{ route('agendar.exp') }}"
                               class="inline-block bg-green-600 hover:bg-green-700 px-6 py-3 rounded-lg font-semibold transition-colors">
                                Agenda uma aula
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

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

    {{-- Script da calculadora interativa --}}
    @if($valores->isNotEmpty())
        <script>
            (function () {
                // Faixas vindas do banco (ordenadas por aulas_mes crescente)
                const faixas = @json($valores->map(fn($v) => [
                    'aulas_mes'  => (int) $v->aulas_mes,
                    'valor_aula' => (float) $v->valor_aula,
                ])->values());

                // Limite máximo permitido pela maior faixa cadastrada
                const limiteMaximo = faixas.length ? faixas[faixas.length - 1].aulas_mes : 1;
                // WhatsApp configurado (pode ser nulo)
                const whatsappBase = @json($config && $config->whatsapp ? 'https://wa.me/55' . preg_replace('/\D/', '', $config->whatsapp) : null);

                // Elementos da página
                const elQtd        = document.getElementById('qtd-aulas');
                const elValorAula  = document.getElementById('valor-aula');
                const elValorTotal = document.getElementById('valor-total');
                const btnDiminuir  = document.getElementById('btn-diminuir');
                const btnAumentar  = document.getElementById('btn-aumentar');
                const linkWpp      = document.getElementById('link-whatsapp');

                // Quantidade inicial (padrão = 4 ou o limite máximo se for menor)
                let quantidade = Math.min(4, limiteMaximo);

                // Formata um número como moeda brasileira (R$ 1.234,56)
                function formatarMoeda(valor) {
                    return 'R$ ' + valor.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }

                // Encontra a faixa de preço que atende à quantidade escolhida
                function encontrarFaixa(qtd) {
                    for (const faixa of faixas) {
                        if (qtd <= faixa.aulas_mes) return faixa;
                    }
                    return faixas[faixas.length - 1];
                }

                // Atualiza a tela com base na quantidade atual
                function atualizar() {
                    const faixa = encontrarFaixa(quantidade);
                    const total = faixa.valor_aula * quantidade;

                    elQtd.textContent        = quantidade;
                    elValorAula.textContent  = formatarMoeda(faixa.valor_aula);
                    elValorTotal.textContent = formatarMoeda(total);

                    // Habilita/desabilita botões nos limites
                    btnDiminuir.disabled = quantidade <= 1;
                    btnAumentar.disabled = quantidade >= limiteMaximo;
                    btnDiminuir.classList.toggle('opacity-40', btnDiminuir.disabled);
                    btnDiminuir.classList.toggle('cursor-not-allowed', btnDiminuir.disabled);
                    btnAumentar.classList.toggle('opacity-40', btnAumentar.disabled);
                    btnAumentar.classList.toggle('cursor-not-allowed', btnAumentar.disabled);

                    // Atualiza link do WhatsApp com a simulação selecionada
                    if (linkWpp && whatsappBase) {
                        const texto = `Olá! Tenho interesse em ${quantidade} ${quantidade === 1 ? 'aula' : 'aulas'} por mês ` +
                                      `(${formatarMoeda(faixa.valor_aula)} por aula, total ${formatarMoeda(total)}).`;
                        linkWpp.href = `${whatsappBase}?text=${encodeURIComponent(texto)}`;
                    }
                }

                // Eventos dos botões -/+
                btnDiminuir.addEventListener('click', () => {
                    if (quantidade > 1) { quantidade--; atualizar(); }
                });
                btnAumentar.addEventListener('click', () => {
                    if (quantidade < limiteMaximo) { quantidade++; atualizar(); }
                });

                atualizar();
            })();
        </script>
    @endif
@endsection
