<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Otimizado para Landing Page -->
    <title>@yield('title', 'Boxing House PF - Academia de Boxe em Passo Fundo | Treinamento Personal')</title>
    <meta name="description" content="@yield('description', 'Academia de boxe em Passo Fundo com treinamento personal. Turmas fechadas com máximo 3 alunos, aulas de 1h10min. Equipamentos específicos para seu desenvolvimento no boxe.')">
    <meta name="keywords" content="@yield('keywords', 'academia boxe passo fundo, treinamento personal boxe, boxing house pf, aulas boxe, treino boxe rs, academia passo fundo')">
    <meta name="author" content="Boxing House PF">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / WhatsApp / Facebook -->
    <meta property="og:site_name" content="Boxing House PF">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('og_title', 'Boxing House PF - Academia de Boxe em Passo Fundo')">
    <meta property="og:description" content="@yield('og_description', 'Treinamento personal de boxe com turmas fechadas de até 3 alunos. Equipamentos específicos e aulas de 1h10min em Passo Fundo/RS.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('capa.png') }}">
    <meta property="og:image:alt" content="Boxing House PF - Academia de Boxe">
    <meta property="og:locale" content="pt_BR">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'Boxing House PF - Academia de Boxe Passo Fundo')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Academia de boxe com treinamento personal. Turmas pequenas, equipamentos específicos.')">
    <meta name="twitter:image" content="{{ asset('capa.png') }}">

    <!-- PWA & Favicons -->
    <meta name="theme-color" content="#1e40af">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Styles -->
    <style>
        .bg-gradient-hero {
            background: linear-gradient(135deg, #1e40af 0%, #2563eb 50%, #3b82f6 100%);
        }
        .bg-gradient-section {
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
        }
        .scroll-smooth {
            scroll-behavior: smooth;
        }
        .hero-bg {
            background-image: linear-gradient(rgba(15, 23, 42, 0.85), rgba(30, 41, 59, 0.85)), url('/capa.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>

    @yield('head')
</head>
<body class="bg-gray-900 text-white scroll-smooth font-inter">
    @yield('content')

    @yield('scripts')
</body>
</html>