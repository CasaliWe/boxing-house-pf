@extends('layouts.app')

@section('title', 'Mensalidade em Atraso')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl mx-auto space-y-8 text-center">
        <!-- Card Principal -->
        <div class="bg-gradient-card border border-yellow-600 rounded-xl p-8 shadow-2xl">
            <div class="mb-6">
                <div class="text-6xl mb-4">⚠️</div>
                <h1 class="text-3xl font-bold text-yellow-400 mb-4">Mensalidade em Atraso</h1>
                <p class="text-gray-300 text-lg leading-relaxed">
                    Olá <span class="text-blue-400 font-semibold">{{ $user->name }}</span>! 
                    Identificamos que sua mensalidade está em atraso desde 
                    <span class="text-yellow-400 font-semibold">{{ $user->vencimento_at ? \Illuminate\Support\Carbon::parse($user->vencimento_at)->format('d/m/Y') : 'data não definida' }}</span>.
                </p>
            </div>

            <div class="bg-gray-900 border border-gray-700 rounded-xl p-6 mb-6">
                <p class="text-gray-300 text-base leading-relaxed">
                    Para manter seu acesso ao sistema e continuar participando dos treinos, 
                    é necessário regularizar o pagamento da mensalidade. 
                    Após a confirmação do pagamento, seu acesso será reativado automaticamente.
                </p>
            </div>

            <!-- Informações de Pagamento -->
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                @if($config && $config->pix)
                    <div class="bg-blue-900/30 border border-blue-600 rounded-xl p-6">
                        <div class="text-2xl mb-3">💳</div>
                        <h3 class="text-lg font-semibold text-blue-400 mb-3">Chave PIX</h3>
                        <div class="bg-gray-900 rounded-lg p-3 border border-gray-600 mb-4">
                            <p class="text-gray-200 font-mono text-sm break-all">{{ $config->pix }}</p>
                        </div>
                        <button onclick="copiarPix()" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-sm font-medium transition-colors">
                            📋 Copiar Chave PIX
                        </button>
                    </div>
                @endif

                <div class="bg-green-900/30 border border-green-600 rounded-xl p-6">
                    <div class="text-2xl mb-3">📱</div>
                    <h3 class="text-lg font-semibold text-green-400 mb-3">Enviar Comprovante</h3>
                    <p class="text-gray-300 text-sm mb-4">Após realizar o pagamento, envie o comprovante pelo WhatsApp</p>
                    @if($config && $config->whatsapp)
                        <a href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}?text=Olá! Realizei o pagamento da mensalidade e gostaria de enviar o comprovante para reativar meu acesso. Nome: {{ $user->name }}" 
                           target="_blank"
                           class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 rounded-lg text-sm font-medium transition-colors inline-flex items-center justify-center gap-2">
                            <span>💬</span> Enviar Comprovante
                        </a>
                    @endif
                </div>
            </div>

            <!-- Contatos Adicionais -->
            @if($config && ($config->instagram || $config->whatsapp))
                <div class="border-t border-gray-700 pt-6">
                    <h3 class="text-lg font-semibold text-gray-300 mb-4">Outros Contatos</h3>
                    <div class="flex justify-center gap-4">
                        @if($config->whatsapp)
                            <a href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}" 
                               target="_blank"
                               class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-sm transition-colors flex items-center gap-2">
                                <span>📞</span> {{ $config->whatsapp }}
                            </a>
                        @endif
                        @if($config->instagram)
                            <a href="https://instagram.com/{{ str_replace('@', '', $config->instagram) }}" 
                               target="_blank"
                               class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-sm transition-colors flex items-center gap-2">
                                <span>📷</span> {{ $config->instagram }}
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Botão Sair -->
        <div class="pt-4">
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="px-6 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg font-medium transition-colors">
                    🚪 Sair do Sistema
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function copiarPix() {
        const pixText = `{{ $config && $config->pix ? $config->pix : '' }}`;
        if (navigator.clipboard && pixText) {
            navigator.clipboard.writeText(pixText).then(function() {
                // Feedback visual
                const btn = event.target;
                const originalText = btn.innerHTML;
                btn.innerHTML = '✅ Copiado!';
                btn.classList.add('bg-green-600');
                btn.classList.remove('bg-blue-600');
                
                setTimeout(function() {
                    btn.innerHTML = originalText;
                    btn.classList.remove('bg-green-600');
                    btn.classList.add('bg-blue-600');
                }, 2000);
            }).catch(function() {
                alert('Copiado - PIX: ' + pixText);
            });
        } else {
            alert('PIX: ' + pixText);
        }
    }
</script>
@endsection