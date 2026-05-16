{{-- Topbar enxuta: hambúrguer no mobile, identificação do usuário e botão sair --}}
<header class="bg-gradient-topbar border-b border-gray-800 px-5 py-2.5 flex items-center justify-between">
    {{-- Botão hambúrguer (apenas mobile) --}}
    <button type="button" class="md:hidden text-gray-300 hover:text-blue-400 transition-colors" id="mobileMenuBtn" aria-label="Abrir menu">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>

    {{-- Identificação do usuário + logout --}}
    <div class="flex items-center gap-4 ml-auto">
        <div class="text-right leading-tight hidden sm:block">
            <div class="text-sm font-medium text-white">{{ auth()->user()->name }}</div>
            <div class="text-xs text-blue-400">{{ ucfirst(auth()->user()->role) }}</div>
        </div>

        {{-- Botão de sair (ícone-only no mobile, ícone + texto no desktop) --}}
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit"
                    class="inline-flex items-center gap-1.5 bg-red-600/90 hover:bg-red-600 text-white text-xs font-medium px-3 py-1.5 rounded-md transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span class="hidden sm:inline">Sair</span>
            </button>
        </form>
    </div>
</header>
