@extends('layouts.app')

@section('title', 'Cadastro enviado')

@section('content')
<div class="max-w-2xl mx-auto space-y-8 text-center">
    <div>
        <h1 class="text-3xl font-bold text-blue-400">🎉 Cadastro Enviado</h1>
        <p class="text-gray-300 mt-2">Recebemos suas informações. Seu cadastro está <span class="text-yellow-300">pendente</span> de confirmação.</p>
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        <p class="text-gray-300">Para concluir, realize o pagamento via PIX e envie o comprovante pelo WhatsApp da academia.</p>
        <p class="text-gray-400 mt-2">Assim que confirmarmos o pagamento, ativaremos seu acesso.</p>

        @if(isset($config))
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4 text-left">
                <div class="bg-gray-900/60 border border-gray-700 rounded-lg p-4">
                    <div class="text-gray-400 text-sm">Chave PIX</div>
                    <div id="pixValue" class="text-white font-semibold break-all">{{ $config->pix }}</div>
                    <div class="mt-3 flex gap-2">
                        <button type="button" class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded" onclick="copyToClipboard('pixValue')">Copiar PIX</button>
                    </div>
                </div>
                <div class="bg-gray-900/60 border border-gray-700 rounded-lg p-4">
                    <div class="text-gray-400 text-sm">WhatsApp</div>
                    <div id="waValue" class="text-white font-semibold break-all">{{ $config->whatsapp }}</div>
                    @php
                        $digits = preg_replace('/\D+/', '', $config->whatsapp ?? '');
                    @endphp
                    <div class="mt-3 flex gap-2">
                        <a href="https://wa.me/{{ $digits }}" target="_blank" rel="noopener" class="px-3 py-2 bg-green-600 hover:bg-green-700 text-white rounded">Abrir WhatsApp</a>
                        <button type="button" class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded" onclick="copyToClipboard('waValue')">Copiar número</button>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div>
        <a href="{{ route('home') }}" class="px-5 py-3 rounded-md bg-blue-600 hover:bg-blue-700 text-white">Voltar à página inicial</a>
    </div>
</div>

<script>
function copyToClipboard(elementId){
    const el = document.getElementById(elementId);
    if(!el) return;
    const text = el.textContent.trim();
    if(navigator.clipboard){
        navigator.clipboard.writeText(text).then(()=>{
            alert('Copiado!');
        }).catch(()=>{
            fallbackCopy(text);
        });
    } else {
        fallbackCopy(text);
    }
}
function fallbackCopy(text){
    const ta = document.createElement('textarea');
    ta.value = text;
    document.body.appendChild(ta);
    ta.select();
    try { document.execCommand('copy'); alert('Copiado!'); } catch(e){}
    document.body.removeChild(ta);
}
</script>
@endsection
