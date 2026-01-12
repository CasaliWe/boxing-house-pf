<!-- Topbar -->
<header class="bg-gradient-topbar border-b border-gray-700 px-6 py-4 flex items-center justify-between">
    <button type="button" class="md:hidden text-white hover:text-blue-400 transition-colors" id="mobileMenuBtn">
        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>

    <div class="flex items-center space-x-4 ml-auto">
        <div class="text-gray-300 text-sm">
            <span class="font-medium">{{ auth()->user()->name }}</span>
            <span class="text-blue-400 ml-2">({{ ucfirst(auth()->user()->role) }})</span>
        </div>

        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="bg-gradient-red hover:bg-gradient-red text-white px-4 py-2 rounded-lg transition-all duration-300 hover:-translate-y-1 flex items-center space-x-2">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span>Sair</span>
            </button>
        </form>
    </div>
</header>