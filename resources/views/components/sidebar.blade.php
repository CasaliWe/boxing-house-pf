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
                <a href="{{ route('professor.horarios.index') }}" 
                   class="flex items-center px-6 py-4 text-gray-300 hover:text-white rounded-lg transition-all duration-300 nav-hover {{ request()->routeIs('professor.horarios.*') ? 'bg-gradient-blue text-white' : 'hover:bg-gradient-blue' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z" />
                    </svg>
                    Horários
                </a>
            </div>

            <div class="px-4 mb-2">
                <a href="{{ route('professor.regras.index') }}" 
                   class="flex items-center px-6 py-4 text-gray-300 hover:text-white rounded-lg transition-all duration-300 nav-hover {{ request()->routeIs('professor.regras.*') ? 'bg-gradient-blue text-white' : 'hover:bg-gradient-blue' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-7 4h8M5 6h14M7 8h10M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Regras e Aceites
                </a>
            </div>

            <div class="px-4 mb-2">
                <a href="{{ route('professor.valores.index') }}" 
                   class="flex items-center px-6 py-4 text-gray-300 hover:text-white rounded-lg transition-all duration-300 nav-hover {{ request()->routeIs('professor.valores.*') ? 'bg-gradient-blue text-white' : 'hover:bg-gradient-blue' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-2.21 0-4 .9-4 2s1.79 2 4 2 4 .9 4 2-1.79 2-4 2m0-8v10m0-10c1.862 0 3.5.805 3.5 1.8M12 8C10.138 8 8.5 8.805 8.5 9.8" />
                    </svg>
                    Valores
                </a>
            </div>

            <div class="px-4 mb-2">
                <a href="{{ route('professor.config.edit') }}" 
                   class="flex items-center px-6 py-4 text-gray-300 hover:text-white rounded-lg transition-all duration-300 nav-hover {{ request()->routeIs('professor.config.*') ? 'bg-gradient-blue text-white' : 'hover:bg-gradient-blue' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-1.14 1.603-1.14 1.902 0a1.724 1.724 0 002.592 1.117c1.02-.59 2.262.652 1.672 1.672a1.724 1.724 0 001.117 2.592c1.14.3 1.14 1.603 0 1.902a1.724 1.724 0 00-1.117 2.592c.59 1.02-.652 2.262-1.672 1.672a1.724 1.724 0 00-2.592 1.117c-.3 1.14-1.603 1.14-1.902 0a1.724 1.724 0 00-2.592-1.117c-1.02.59-2.262-.652-1.672-1.672a1.724 1.724 0 00-1.117-2.592c-1.14-.3-1.14-1.603 0-1.902a1.724 1.724 0 001.117-2.592c-.59-1.02.652-2.262 1.672-1.672.989.571 2.292-.174 2.592-1.117z" />
                    </svg>
                    Config
                </a>
            </div>

            <div class="px-4 mb-2">
                <a href="{{ route('professor.aprovacoes.index') }}" 
                   class="flex items-center px-6 py-4 text-gray-300 hover:text-white rounded-lg transition-all duration-300 nav-hover {{ request()->routeIs('professor.aprovacoes.*') ? 'bg-gradient-blue text-white' : 'hover:bg-gradient-blue' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Aprovações
                </a>
            </div>
            
            <div class="px-4 mb-2">
                <a href="{{ route('professor.alunos.index') }}" class="flex items-center px-6 py-4 text-gray-300 hover:text-white rounded-lg transition-all duration-300 nav-hover {{ request()->routeIs('professor.alunos.*') ? 'bg-gradient-blue text-white' : 'hover:bg-gradient-blue' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    Alunos
                </a>
            </div>

            <div class="px-4 mb-2">
                <a href="{{ route('professor.treinos.index') }}" class="flex items-center px-6 py-4 text-gray-300 hover:text-white rounded-lg transition-all duration-300 nav-hover {{ request()->routeIs('professor.treinos.*') ? 'bg-gradient-blue text-white' : 'hover:bg-gradient-blue' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    Treinos
                </a>
            </div>

            <div class="px-4 mb-2">
                <a href="{{ route('professor.aulas-sequencia.index') }}" class="flex items-center px-6 py-4 text-gray-300 hover:text-white rounded-lg transition-all duration-300 nav-hover {{ request()->routeIs('professor.aulas-sequencia.*') ? 'bg-gradient-blue text-white' : 'hover:bg-gradient-blue' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Sequência de Aulas
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
                <a href="{{ route('aluno.regras') }}" class="flex items-center px-6 py-4 text-gray-300 hover:text-white rounded-lg transition-all duration-300 nav-hover {{ request()->routeIs('aluno.regras') ? 'bg-gradient-blue text-white' : 'hover:bg-gradient-blue' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 6h14M7 8h10M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Regras do CT
                </a>
            </div>

            <div class="px-4 mb-2">
                <a href="{{ route('aluno.perfil') }}" class="flex items-center px-6 py-4 text-gray-300 hover:text-white rounded-lg transition-all duration-300 nav-hover {{ request()->routeIs('aluno.perfil') ? 'bg-gradient-blue text-white' : 'hover:bg-gradient-blue' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Meu Perfil
                </a>
            </div>

            <div class="px-4 mb-2">
                <a href="{{ route('aluno.horarios') }}" class="flex items-center px-6 py-4 text-gray-300 hover:text-white rounded-lg transition-all duration-300 nav-hover {{ request()->routeIs('aluno.horarios') ? 'bg-gradient-blue text-white' : 'hover:bg-gradient-blue' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z" />
                    </svg>
                    Meus Horários
                </a>
            </div>

            <div class="px-4 mb-2">
                <a href="{{ route('aluno.treinos') }}" class="flex items-center px-6 py-4 text-gray-300 hover:text-white rounded-lg transition-all duration-300 nav-hover {{ request()->routeIs('aluno.treinos') ? 'bg-gradient-blue text-white' : 'hover:bg-gradient-blue' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    Meus Treinos
                </a>
            </div>
        @endif
    </nav>
</aside>