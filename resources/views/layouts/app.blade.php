<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO -->
    <meta name="description" content="Boxing House PF - Sistema de academia de boxe: gestão de alunos, treinos, horários e sequências.">
    <meta name="keywords" content="boxe, academia, treinos, boxing house, professor, aluno">
    <meta name="author" content="Boxing House PF">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / WhatsApp thumb -->
    <meta property="og:site_name" content="Boxing House PF">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ config('app.name', 'Boxing House PF') }}">
    <meta property="og:description" content="Gerencie seus treinos e horários na Boxing House PF.">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('favicon.png') }}">
    <meta property="og:image:alt" content="Boxing House PF">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ config('app.name', 'Boxing House PF') }}">
    <meta name="twitter:description" content="Gerencie seus treinos e horários na Boxing House PF.">
    <meta name="twitter:image" content="{{ asset('favicon.png') }}">

    <!-- PWA -->
    <meta name="theme-color" content="#0ea5e9">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <title>{{ config('app.name', 'Boxing House PF') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Apenas CSS personalizado necessário */
        .bg-gradient-dark {
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);
        }
        
        .bg-gradient-sidebar {
            background: linear-gradient(180deg, #1a1a1a 0%, #2a2a2a 100%);
        }
        
        .bg-gradient-topbar {
            background: linear-gradient(90deg, #1a1a1a 0%, #2a2a2a 100%);
        }
        
        .bg-gradient-card {
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
        }
        
        .bg-gradient-blue {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }
        
        .bg-gradient-red {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        }
        
        .bg-gradient-red:hover {
            background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
        }
        
        .nav-hover:hover {
            transform: translateX(4px);
        }
        
        /* Oculta a scrollbar da sidebar mantendo a rolagem funcional */
        #sidebar nav {
            -ms-overflow-style: none; /* IE e Edge */
            scrollbar-width: none;    /* Firefox */
        }
        #sidebar nav::-webkit-scrollbar { /* Chrome, Safari, Opera */
            display: none;
        }
        
        /* Garantir que o mobile menu funcione corretamente */
        @media (max-width: 767px) {
            #sidebar {
                transform: translateX(-100%);
            }
            
            #sidebar:not(.-translate-x-full) {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body class="bg-gradient-dark text-white font-inter overflow-hidden">
    <div class="flex h-screen">
        @auth
            @include('components.sidebar')
        @endauth

        <div class="flex-1 flex flex-col min-w-0">
            @auth
                @include('components.topbar')
            @endauth

            <main class="flex-1 p-6 md:p-8 overflow-y-auto">
                <!-- Alertas de erro/sucesso -->
                @if (session('error'))
                    <div class="bg-gradient-red text-white px-6 py-4 rounded-lg mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-4 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile overlay -->
    <div class="hidden fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden" id="mobileOverlay"></div>

    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileBtn = document.getElementById('mobileMenuBtn');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');

            if (mobileBtn && sidebar) {
                mobileBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('-translate-x-full');
                    overlay.classList.toggle('hidden');
                });

                overlay.addEventListener('click', function() {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                });
            }

            // PWA: registrar service worker
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function() {
                    navigator.serviceWorker.register('{{ asset('sw.js') }}').catch(function(err){
                        console.error('SW registration failed', err);
                    });
                });
            }
        });
    </script>
</body>
</html>