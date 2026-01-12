<!-- Sidebar -->
<aside class="w-72 bg-gradient-sidebar border-r border-gray-700 transition-transform duration-300 ease-in-out -translate-x-full md:translate-x-0 fixed md:static h-screen z-50 flex flex-col" id="sidebar">
    <div class="p-8 border-b border-gray-700 text-center flex-shrink-0">
        <h1 class="text-blue-400 text-2xl font-bold uppercase tracking-wider">Boxing House PF</h1>
    </div>

    <nav class="py-6 flex-1 overflow-y-auto">
        @if(auth()->user()->role === 'professor')
            <div class="px-4 mb-2">
                <a href="{{ route('professor.dashboard') }}" 
                   class="flex items-center px-6 py-4 text-gray-300 hover:text-white rounded-lg transition-all duration-300 nav-hover {{ request()->routeIs('professor.dashboard') ? 'bg-gradient-blue text-white' : 'hover:bg-gradient-blue' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                    </svg>
                    Dashboard
                </a>
            </div>
            
            <div class="px-4 mb-2">
                <a href="#" class="flex items-center px-6 py-4 text-gray-300 hover:text-white rounded-lg transition-all duration-300 nav-hover hover:bg-gradient-blue">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    Alunos
                </a>
            </div>

            <div class="px-4 mb-2">
                <a href="#" class="flex items-center px-6 py-4 text-gray-300 hover:text-white rounded-lg transition-all duration-300 nav-hover hover:bg-gradient-blue">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    Treinos
                </a>
            </div>

            <div class="px-4 mb-2">
                <a href="#" class="flex items-center px-6 py-4 text-gray-300 hover:text-white rounded-lg transition-all duration-300 nav-hover hover:bg-gradient-blue">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Relatórios
                </a>
            </div>

        @else
            <div class="px-4 mb-2">
                <a href="{{ route('aluno.dashboard') }}" 
                   class="flex items-center px-6 py-4 text-gray-300 hover:text-white rounded-lg transition-all duration-300 nav-hover {{ request()->routeIs('aluno.dashboard') ? 'bg-gradient-blue text-white' : 'hover:bg-gradient-blue' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                    </svg>
                    Meu Dashboard
                </a>
            </div>

            <div class="px-4 mb-2">
                <a href="#" class="flex items-center px-6 py-4 text-gray-300 hover:text-white rounded-lg transition-all duration-300 nav-hover hover:bg-gradient-blue">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    Meus Treinos
                </a>
            </div>

            <div class="px-4 mb-2">
                <a href="#" class="flex items-center px-6 py-4 text-gray-300 hover:text-white rounded-lg transition-all duration-300 nav-hover hover:bg-gradient-blue">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Meu Perfil
                </a>
            </div>

            <div class="px-4 mb-2">
                <a href="#" class="flex items-center px-6 py-4 text-gray-300 hover:text-white rounded-lg transition-all duration-300 nav-hover hover:bg-gradient-blue">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Histórico
                </a>
            </div>
        @endif
    </nav>
</aside>