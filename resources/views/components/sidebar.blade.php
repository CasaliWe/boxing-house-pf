{{-- Sidebar lateral compacta e elegante --}}
<aside id="sidebar"
       class="w-60 bg-gradient-sidebar border-r border-gray-800 transition-transform duration-300 ease-in-out -translate-x-full md:translate-x-0 fixed md:static h-screen z-50 flex flex-col">

    {{-- Cabeçalho da sidebar com a logo --}}
    <div class="px-4 py-3 border-b border-gray-800 shrink-0 flex justify-center">
        <img src="{{ asset('logo-x.png') }}" alt="Boxing House PF" class="h-9 w-auto">
    </div>

    {{-- Estilos específicos da navegação compacta --}}
    @once
        @push('styles')
        @endpush
    @endonce
    <style>
        /* Item base da sidebar: enxuto, mas com bom alvo de clique */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.625rem;            /* 10px entre ícone e label */
            padding: 0.5rem 0.75rem;  /* py-2 px-3 */
            border-radius: 0.5rem;
            font-size: 0.8125rem;     /* 13px */
            font-weight: 500;
            color: #d1d5db;           /* gray-300 */
            transition: all 0.15s ease;
        }
        .nav-item:hover {
            background-color: rgba(59, 130, 246, 0.1);
            color: #ffffff;
        }
        .nav-item.active {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #ffffff;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }
        .nav-item svg {
            width: 1rem;              /* 16px */
            height: 1rem;
            flex-shrink: 0;
            opacity: 0.85;
        }
        .nav-section-title {
            font-size: 0.6875rem;     /* 11px */
            font-weight: 600;
            color: #6b7280;           /* gray-500 */
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0 0.75rem;
            margin-bottom: 0.25rem;
        }
    </style>

    {{-- Navegação principal --}}
    <nav class="flex-1 overflow-y-auto px-2 py-4 space-y-5">
        @if(auth()->user()->role === 'professor')
            {{-- Seção: Visão geral --}}
            <div class="space-y-0.5">
                <div class="nav-section-title">Visão geral</div>
                <a href="{{ route('professor.dashboard') }}"
                   class="nav-item {{ request()->routeIs('professor.dashboard') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('professor.tarefas.index') }}"
                   class="nav-item {{ request()->routeIs('professor.tarefas.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    Fazer
                </a>
                <a href="{{ route('professor.aprovacoes.index') }}"
                   class="nav-item {{ request()->routeIs('professor.aprovacoes.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Aprovações
                </a>
                <a href="{{ route('professor.mensalidades.index') }}"
                   class="nav-item {{ request()->routeIs('professor.mensalidades.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Controle de Aulas
                </a>
                <a href="{{ route('professor.movimentacoes.index') }}"
                   class="nav-item {{ request()->routeIs('professor.movimentacoes.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-7v14m-7 0h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Entradas e Saídas
                </a>
                <a href="{{ route('professor.aulas-exp.index') }}"
                   class="nav-item {{ request()->routeIs('professor.aulas-exp.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Aulas EXP
                </a>
            </div>

            {{-- Seção: Cadastros --}}
            <div class="space-y-0.5">
                <div class="nav-section-title">Cadastros</div>
                <a href="{{ route('professor.alunos.index') }}"
                   class="nav-item {{ request()->routeIs('professor.alunos.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                    Alunos
                </a>
                <a href="{{ route('professor.horarios.index') }}"
                   class="nav-item {{ request()->routeIs('professor.horarios.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z" />
                    </svg>
                    Horários
                </a>
                <a href="{{ route('professor.treinos.index') }}"
                   class="nav-item {{ request()->routeIs('professor.treinos.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Treinos
                </a>
                <a href="{{ route('professor.aulas-sequencia.index') }}"
                   class="nav-item {{ request()->routeIs('professor.aulas-sequencia.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Sequência de Aulas
                </a>
                <a href="{{ route('professor.valores.index') }}"
                   class="nav-item {{ request()->routeIs('professor.valores.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-2.21 0-4 .9-4 2s1.79 2 4 2 4 .9 4 2-1.79 2-4 2m0-8v10m0-10c1.862 0 3.5.805 3.5 1.8M12 8C10.138 8 8.5 8.805 8.5 9.8" />
                    </svg>
                    Valores
                </a>
            </div>

            {{-- Seção: Conteúdo --}}
            <div class="space-y-0.5">
                <div class="nav-section-title">Conteúdo</div>
                <a href="{{ route('professor.ideias-exercicios.index') }}"
                   class="nav-item {{ request()->routeIs('professor.ideias-exercicios.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    Ideias de Exercícios
                </a>
                <a href="{{ route('professor.avaliacoes.index') }}"
                   class="nav-item {{ request()->routeIs('professor.avaliacoes.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.6.9-1 1.651-1.155.751-.154 1.532.055 2.152.625L19.64 6.55a2 2 0 01.25 2.83l-7.18 8.61c-.34.407-.808.695-1.335.82L9 19.5l.694-2.375c.125-.527.413-.995.82-1.335l8.61-7.18a2 2 0 002.83.25z" />
                    </svg>
                    Avaliações
                </a>
            </div>

            {{-- Seção: Configurações --}}
            <div class="space-y-0.5">
                <div class="nav-section-title">Configurações</div>
                <a href="{{ route('professor.regras.index') }}"
                   class="nav-item {{ request()->routeIs('professor.regras.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-7 4h8M5 6h14M7 8h10M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Regras e Aceites
                </a>
                <a href="{{ route('professor.config.edit') }}"
                   class="nav-item {{ request()->routeIs('professor.config.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-1.14 1.603-1.14 1.902 0a1.724 1.724 0 002.592 1.117c1.02-.59 2.262.652 1.672 1.672a1.724 1.724 0 001.117 2.592c1.14.3 1.14 1.603 0 1.902a1.724 1.724 0 00-1.117 2.592c.59 1.02-.652 2.262-1.672 1.672a1.724 1.724 0 00-2.592 1.117c-.3 1.14-1.603 1.14-1.902 0a1.724 1.724 0 00-2.592-1.117c-1.02.59-2.262-.652-1.672-1.672a1.724 1.724 0 00-1.117-2.592c-1.14-.3-1.14-1.603 0-1.902a1.724 1.724 0 001.117-2.592c-.59-1.02.652-2.262 1.672-1.672.989.571 2.292-.174 2.592-1.117z" />
                    </svg>
                    Configurações
                </a>
                <a href="{{ route('professor.professor.edit') }}"
                   class="nav-item {{ request()->routeIs('professor.professor.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Professor
                </a>
                <a href="{{ route('professor.app.index') }}"
                   class="nav-item {{ request()->routeIs('professor.app.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    App
                </a>
            </div>

        @else
            {{-- Sidebar do aluno --}}
            <div class="space-y-0.5">
                <div class="nav-section-title">Início</div>
                <a href="{{ route('aluno.dashboard') }}"
                   class="nav-item {{ request()->routeIs('aluno.dashboard') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Meu Dashboard
                </a>
            </div>

            <div class="space-y-0.5">
                <div class="nav-section-title">Treinos</div>
                <a href="{{ route('aluno.horarios') }}"
                   class="nav-item {{ request()->routeIs('aluno.horarios') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z" />
                    </svg>
                    Meus Horários
                </a>
                <a href="{{ route('aluno.treinos') }}"
                   class="nav-item {{ request()->routeIs('aluno.treinos') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Meus Treinos
                </a>
                <a href="{{ route('aluno.anotacoes.index') }}"
                   class="nav-item {{ request()->routeIs('aluno.anotacoes.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Minhas Anotações
                </a>
            </div>

            <div class="space-y-0.5">
                <div class="nav-section-title">Academia</div>
                <a href="{{ route('aluno.regras') }}"
                   class="nav-item {{ request()->routeIs('aluno.regras') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 6h14M7 8h10M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Regras do CT
                </a>
                <a href="{{ route('aluno.avaliar.index') }}"
                   class="nav-item {{ request()->routeIs('aluno.avaliar.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.6.9-1 1.651-1.155.751-.154 1.532.055 2.152.625L19.64 6.55a2 2 0 01.25 2.83l-7.18 8.61c-.34.407-.808.695-1.335.82L9 19.5l.694-2.375c.125-.527.413-.995.82-1.335l8.61-7.18a2 2 0 002.83.25z" />
                    </svg>
                    Avaliar a academia
                </a>
            </div>

            <div class="space-y-0.5">
                <div class="nav-section-title">Conta</div>
                <a href="{{ route('aluno.perfil') }}"
                   class="nav-item {{ request()->routeIs('aluno.perfil') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Meu Perfil
                </a>
            </div>
        @endif
    </nav>
</aside>
