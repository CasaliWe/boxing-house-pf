@extends('layouts.app')

@section('title', 'Senhas e Acessos')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Senhas e Acessos</h1>
            <p class="text-sm text-gray-400 mt-1">Guarde URLs, logins e senhas das plataformas</p>
        </div>
        <a href="{{ route('professor.acessos.create') }}"
           style="background-color: #2563eb; color: #ffffff;"
           onmouseover="this.style.backgroundColor='#1d4ed8'"
           onmouseout="this.style.backgroundColor='#2563eb'"
           class="inline-flex items-center justify-center gap-2 text-sm font-medium px-4 py-2 rounded-md transition-colors w-full sm:w-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Novo acesso
        </a>
    </div>

    @if($acessos->isEmpty())
        <div class="bg-gray-900/60 border border-gray-800 rounded-lg p-10 text-center">
            <div class="text-gray-300 font-semibold">Nenhum acesso cadastrado.</div>
            <div class="text-sm text-gray-500 mt-1">Adicione a primeira plataforma acima.</div>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            @foreach($acessos as $acesso)
                <div class="bg-gray-900/60 border border-gray-800 rounded-lg p-5 space-y-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <h2 class="text-lg font-semibold text-white break-words">{{ $acesso->plataforma }}</h2>
                            @if($acesso->url)
                                <a href="{{ str_starts_with($acesso->url, 'http') ? $acesso->url : 'https://' . $acesso->url }}"
                                   target="_blank"
                                   class="text-xs text-blue-300 hover:text-blue-200 break-all mt-1 inline-block">
                                    {{ $acesso->url }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="bg-gray-800/50 border border-gray-700 rounded-md p-3 min-w-0">
                            <div class="text-xs text-gray-500 uppercase tracking-wider mb-1">Login</div>
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-sm text-gray-200 truncate">{{ $acesso->login ?: '-' }}</span>
                                <button type="button" onclick="copiarAcesso(this, @js($acesso->login ?? ''))" title="Copiar login"
                                        class="shrink-0 inline-flex items-center justify-center w-8 h-8 rounded-md text-gray-300 hover:text-white hover:bg-gray-700 transition-colors {{ $acesso->login ? '' : 'opacity-40 cursor-not-allowed' }}"
                                        {{ $acesso->login ? '' : 'disabled' }}>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16h8M8 12h8m-7 8h6a2 2 0 002-2V7.5L13.5 4H9a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </button>
                            </div>
                        </div>

                        <div class="bg-gray-800/50 border border-gray-700 rounded-md p-3 min-w-0">
                            <div class="text-xs text-gray-500 uppercase tracking-wider mb-1">Senha</div>
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-sm text-gray-200 truncate tracking-widest">{{ $acesso->senha ? '••••••••' : '-' }}</span>
                                <button type="button" onclick="copiarAcesso(this, @js($acesso->senha ?? ''))" title="Copiar senha"
                                        class="shrink-0 inline-flex items-center justify-center w-8 h-8 rounded-md text-gray-300 hover:text-white hover:bg-gray-700 transition-colors {{ $acesso->senha ? '' : 'opacity-40 cursor-not-allowed' }}"
                                        {{ $acesso->senha ? '' : 'disabled' }}>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16h8M8 12h8m-7 8h6a2 2 0 002-2V7.5L13.5 4H9a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-800">
                        <a href="{{ route('professor.acessos.edit', $acesso) }}"
                           class="text-xs font-medium px-3 py-1.5 rounded border border-gray-700 text-gray-300 hover:bg-gray-800 transition-colors">
                            Editar
                        </a>
                        <form method="POST" action="{{ route('professor.acessos.destroy', $acesso) }}" onsubmit="return confirm('Excluir este acesso?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    style="background-color: #dc2626; color: #ffffff;"
                                    onmouseover="this.style.backgroundColor='#b91c1c'"
                                    onmouseout="this.style.backgroundColor='#dc2626'"
                                    class="text-xs font-medium px-3 py-1.5 rounded transition-colors">
                                Excluir
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div>
            {{ $acessos->links() }}
        </div>
    @endif
</div>

<script>
    function copiarAcesso(botao, valor) {
        if (!valor) return;

        navigator.clipboard.writeText(valor).then(() => {
            botao.classList.add('text-green-300');
            setTimeout(() => botao.classList.remove('text-green-300'), 1200);
        });
    }
</script>
@endsection
