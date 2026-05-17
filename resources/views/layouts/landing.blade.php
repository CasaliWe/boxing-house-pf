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
    <link href="https://fonts.bunny.net/css?family=montserrat:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- AOS Library for Scroll Animations -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Styles -->
    <style>
        :root {
            --brand-blue:    #3b82f6;
            --brand-blue-2:  #1d4ed8;
            --brand-blue-3:  #0ea5e9;
        }

        body {
            background: #050b1a;
            font-family: 'Montserrat', system-ui, -apple-system, sans-serif;
            font-weight: 400;
            letter-spacing: -0.005em;
        }
        .font-display {
            font-family: 'Montserrat', system-ui, sans-serif;
            font-weight: 700;
            letter-spacing: -0.025em;
        }

        /* ============= GRADIENTES BASE ============= */
        .bg-gradient-hero {
            background: linear-gradient(135deg, #0c1d3d 0%, #1e40af 50%, #0ea5e9 100%);
        }
        .bg-gradient-section {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #111827 100%);
        }
        .scroll-smooth { scroll-behavior: smooth; }

        .hero-bg {
            background-image:
                radial-gradient(1200px 600px at 20% 0%, rgba(14, 165, 233, 0.18), transparent 70%),
                radial-gradient(900px 500px at 80% 100%, rgba(59, 130, 246, 0.18), transparent 70%),
                linear-gradient(rgba(5, 11, 26, 0.92), rgba(5, 11, 26, 0.92)),
                url('/capa.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* ============= TEXTO COM GRADIENTE ============= */
        .text-gradient {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 35%, #ffffff 70%, #c4d8ff 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .text-gradient-blue {
            background: linear-gradient(135deg, #38bdf8 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        /* ============= GLASS / CARDS ============= */
        .glass {
            background: rgba(15, 23, 42, 0.55);
            -webkit-backdrop-filter: blur(12px);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .glass-strong {
            background: rgba(15, 23, 42, 0.75);
            -webkit-backdrop-filter: blur(16px);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Card com gradient border — usa pseudo-elemento para criar a borda */
        .gradient-border {
            position: relative;
            background: rgba(15, 23, 42, 0.8);
            border-radius: 1rem;
            overflow: hidden;
        }
        .gradient-border::before {
            content: '';
            position: absolute;
            inset: 0;
            padding: 1px;
            border-radius: inherit;
            background: linear-gradient(135deg, rgba(59,130,246,0.6), rgba(14,165,233,0.1) 40%, rgba(255,255,255,0.04) 60%, rgba(59,130,246,0.4) 100%);
            -webkit-mask:
                linear-gradient(#000 0 0) content-box,
                linear-gradient(#000 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
            transition: opacity .4s ease;
        }
        .gradient-border:hover::before {
            background: linear-gradient(135deg, rgba(59,130,246,0.9), rgba(14,165,233,0.5) 50%, rgba(59,130,246,0.9) 100%);
        }

        /* Hover de elevação 3D + sweep */
        .card-tilt {
            transition: transform .35s cubic-bezier(.2,.8,.2,1), box-shadow .35s;
            transform-style: preserve-3d;
        }
        .card-tilt:hover {
            transform: translateY(-6px);
            box-shadow:
                0 25px 50px -20px rgba(59, 130, 246, 0.35),
                0 10px 25px -10px rgba(0, 0, 0, 0.5);
        }

        /* ============= BOTÕES ============= */
        .btn-primary {
            position: relative;
            background: linear-gradient(135deg, #16a34a 0%, #22c55e 50%, #16a34a 100%);
            background-size: 200% 200%;
            color: #fff;
            transition: background-position .4s ease, transform .25s ease, box-shadow .3s ease;
            box-shadow:
                0 10px 30px -10px rgba(34, 197, 94, 0.5),
                inset 0 1px 0 rgba(255,255,255,0.2);
        }
        .btn-primary:hover {
            background-position: 100% 50%;
            transform: translateY(-2px);
            box-shadow:
                0 18px 38px -10px rgba(34, 197, 94, 0.6),
                inset 0 1px 0 rgba(255,255,255,0.25);
        }
        .btn-ghost {
            position: relative;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.18);
            color: #fff;
            transition: all .3s ease;
            -webkit-backdrop-filter: blur(6px);
            backdrop-filter: blur(6px);
        }
        .btn-ghost:hover {
            background: rgba(255,255,255,0.12);
            border-color: rgba(255,255,255,0.4);
            transform: translateY(-2px);
        }
        .btn-blue {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 50%, #1d4ed8 100%);
            background-size: 200% 200%;
            color: #fff;
            transition: background-position .4s ease, transform .25s ease, box-shadow .3s ease;
            box-shadow:
                0 10px 30px -10px rgba(59, 130, 246, 0.55),
                inset 0 1px 0 rgba(255,255,255,0.2);
        }
        .btn-blue:hover {
            background-position: 100% 50%;
            transform: translateY(-2px);
            box-shadow:
                0 18px 38px -10px rgba(59, 130, 246, 0.7),
                inset 0 1px 0 rgba(255,255,255,0.25);
        }
        /* Shine effect dentro dos botões */
        .btn-shine { position: relative; overflow: hidden; }
        .btn-shine::after {
            content: '';
            position: absolute;
            top: 0;
            left: -75%;
            width: 50%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255,255,255,0.25), transparent);
            transform: skewX(-20deg);
            transition: left .8s ease;
        }
        .btn-shine:hover::after { left: 125%; }

        /* ============= ANIMAÇÕES ============= */
        @keyframes float-slow {
            0%, 100% { transform: translateY(0) translateX(0); }
            50%      { transform: translateY(-20px) translateX(10px); }
        }
        @keyframes float-medium {
            0%, 100% { transform: translateY(0); }
            50%      { transform: translateY(-12px); }
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.5); }
            50%      { box-shadow: 0 0 30px 8px rgba(59, 130, 246, 0.0); }
        }
        @keyframes shimmer {
            0%   { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }
        @keyframes mesh-shift {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33%      { transform: translate(30px, -20px) scale(1.05); }
            66%      { transform: translate(-20px, 30px) scale(0.95); }
        }
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }
        @keyframes scroll-down {
            0%   { transform: translateY(0); opacity: 0; }
            30%  { opacity: 1; }
            100% { transform: translateY(12px); opacity: 0; }
        }
        @keyframes gradient-x {
            0%, 100% { background-position: 0% 50%; }
            50%      { background-position: 100% 50%; }
        }

        .animate-float-slow   { animation: float-slow 8s ease-in-out infinite; }
        .animate-float-medium { animation: float-medium 5s ease-in-out infinite; }
        .animate-pulse-glow   { animation: pulse-glow 2.5s ease-in-out infinite; }
        .animate-mesh-shift   { animation: mesh-shift 18s ease-in-out infinite; }
        .animate-spin-slow    { animation: spin-slow 25s linear infinite; }
        .animate-scroll-down  { animation: scroll-down 1.8s ease-in-out infinite; }
        .animate-gradient-x   { animation: gradient-x 6s ease infinite; background-size: 200% 200%; }

        /* ============= GLOW BLOBS (DECORATIVOS) ============= */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.5;
            pointer-events: none;
        }
        .blob-blue   { background: radial-gradient(circle, #3b82f6, transparent 70%); }
        .blob-cyan   { background: radial-gradient(circle, #06b6d4, transparent 70%); }
        .blob-violet { background: radial-gradient(circle, #8b5cf6, transparent 70%); }

        /* ============= NOISE / GRAIN OVERLAY ============= */
        .noise-overlay {
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: .05;
            mix-blend-mode: overlay;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='0.85'/%3E%3C/svg%3E");
        }

        /* ============= GRID PATTERN ============= */
        .grid-pattern {
            position: absolute;
            inset: 0;
            pointer-events: none;
            background-image:
                linear-gradient(rgba(59, 130, 246, 0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59, 130, 246, 0.06) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse at center, black 30%, transparent 75%);
        }

        /* ============= SLIDERS ============= */
        /* Slider do professor — proporção retrato 4:5 (boa pra foto vertical) */
        .slider-container {
            position: relative;
            overflow: hidden;
            width: 100%;
            aspect-ratio: 4 / 5;
            border-radius: 1rem;
        }
        .slide {
            position: absolute;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            transition: opacity 1s ease-in-out;
            opacity: 0;
        }
        .slide:first-child { position: relative; opacity: 1; }
        .slide img { width: 100%; height: 100%; object-fit: cover; }
        .slider-indicator {
            cursor: pointer;
            transition: all 0.3s ease;
            width: .5rem;
            height: .5rem;
            border-radius: 999px;
        }
        .slider-indicator:hover { opacity: 0.8; transform: scale(1.2); }

        /* Slider do sistema — proporção 16:9 (Full HD 1920x1080) */
        .sistema-slider-container {
            position: relative;
            overflow: hidden;
            width: 100%;
            aspect-ratio: 16 / 9;
            border-radius: .75rem;
            background: #0f172a;
        }
        .sistema-slide {
            position: absolute;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            transition: opacity 1s ease-in-out;
            opacity: 0;
        }
        .sistema-slide:first-child { position: relative; opacity: 1; }
        .sistema-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .sistema-slider-indicator {
            cursor: pointer;
            transition: all 0.3s ease;
            width: .5rem;
            height: .5rem;
            border-radius: 999px;
        }
        .sistema-slider-indicator:hover { opacity: 0.8; transform: scale(1.2); }

        /* ============= NAV LINK COM UNDERLINE ANIMADO ============= */
        .nav-link {
            position: relative;
            color: #cbd5e1;
            transition: color .25s ease;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -6px;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, #38bdf8, #3b82f6);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform .35s ease;
            border-radius: 999px;
        }
        .nav-link:hover { color: #fff; }
        .nav-link:hover::after { transform: scaleX(1); }

        /* ============= HEADERS DE SEÇÃO ============= */
        .section-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .25rem .75rem;
            border-radius: 999px;
            background: rgba(59,130,246,0.08);
            border: 1px solid rgba(59,130,246,0.25);
            color: #93c5fd;
            font-size: .6875rem;
            font-weight: 600;
            letter-spacing: .12em;
            text-transform: uppercase;
        }
        .section-eyebrow::before {
            content: '';
            display: inline-block;
            width: 5px;
            height: 5px;
            border-radius: 999px;
            background: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.18);
        }

        /* ============= AVATAR INICIAL ============= */
        .avatar-initial {
            background: linear-gradient(135deg, #1d4ed8, #0ea5e9);
            color: #fff;
            font-weight: 700;
        }

        /* ============= ASPAS DECORATIVAS NAS AVALIAÇÕES ============= */
        .quote-mark {
            font-family: Georgia, serif;
            font-size: 3.5rem;
            line-height: .7;
            color: rgba(59, 130, 246, 0.2);
            font-weight: 700;
        }

        /* ============= ESCONDER SCROLLBAR ============= */
        ::-webkit-scrollbar { width: 10px; height: 10px; }
        ::-webkit-scrollbar-track { background: #050b1a; }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #1e40af, #0ea5e9);
            border-radius: 999px;
        }

        /* ============= IFRAME DO MAPS ============= */
        .map-frame { filter: invert(0.92) hue-rotate(180deg) saturate(.9) brightness(.95); }

        /* ============= EFEITOS DE ÍCONES ============= */
        .icon-tile {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            border-radius: 14px;
            background: linear-gradient(135deg, rgba(59,130,246,0.18), rgba(14,165,233,0.08));
            border: 1px solid rgba(59,130,246,0.25);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.05);
            transition: transform .4s ease, box-shadow .4s ease;
        }
        .card-tilt:hover .icon-tile {
            transform: scale(1.08) rotate(-3deg);
            box-shadow:
                0 14px 30px -10px rgba(59,130,246,0.4),
                inset 0 1px 0 rgba(255,255,255,0.1);
        }

        /* ============= PEQUENO HELPER ============= */
        .hover-lift {
            transition: transform .3s ease, box-shadow .3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px -10px rgba(0,0,0,0.4);
        }
    </style>

    @yield('head')
</head>
<body class="bg-gray-950 text-white scroll-smooth font-inter antialiased">
    @yield('content')

    <script>
        // Initialize AOS animations
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 100,
            delay: 60
        });
    </script>

    @yield('scripts')
</body>
</html>
