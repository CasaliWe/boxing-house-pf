@extends('layouts.app')

@section('title', 'Acesso Inativo')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl mx-auto space-y-8 text-center">
        <div class="bg-gradient-card border border-yellow-600 rounded-xl p-8 shadow-2xl">
            <div class="mb-6">
                <div class="text-5xl mb-4">!</div>
                <h1 class="text-3xl font-bold text-yellow-400 mb-4">Acesso inativo</h1>
                <p class="text-gray-300 text-lg leading-relaxed">
                    Olá <span class="text-blue-400 font-semibold">{{ $user->name }}</span>!
                    Seu cadastro está inativo no momento. Entre em contato com a Boxing House PF para regularizar.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-6 mb-6">
                @if($config && $config->pix)
                    <div class="bg-blue-900/30 border border-blue-600 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-blue-400 mb-3">Chave PIX</h3>
                        <div class="bg-gray-900 rounded-lg p-3 border border-gray-600 mb-4">
                            <p class="text-gray-200 font-mono text-sm break-all">{{ $config->pix }}</p>
                        </div>
                        <button onclick="copiarPix()" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-sm font-medium transition-colors">
                            Copiar Chave PIX
                        </button>
                    </div>
                @endif

                <div class="bg-green-900/30 border border-green-600 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-green-400 mb-3">Falar no WhatsApp</h3>
                    <p class="text-gray-300 text-sm mb-4">Chame para regularizar seu acesso ou comprar um novo pacote de aulas.</p>
                    @if($config && $config->whatsapp)
                        <a href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}?text=Olá! Gostaria de regularizar meu acesso. Nome: {{ $user->name }}"
                           target="_blank"
                           class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 rounded-lg text-sm font-medium transition-colors inline-flex items-center justify-center">
                            Abrir WhatsApp
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="pt-4">
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="px-6 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg font-medium transition-colors">
                    Sair do Sistema
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
                const btn = event.target;
                const originalText = btn.innerHTML;
                btn.innerHTML = 'Copiado!';
                setTimeout(function() {
                    btn.innerHTML = originalText;
                }, 2000);
            }).catch(function() {
                alert('PIX: ' + pixText);
            });
        } else {
            alert('PIX: ' + pixText);
        }
    }
</script>
@endsection
