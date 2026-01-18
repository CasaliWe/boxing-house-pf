<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - Boxing House PF</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
        }

        .login-card {
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
            border-radius: 16px;
            padding: 3rem 2rem;
            border: 1px solid #374151;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h1 {
            color: #3b82f6;
            font-size: 2rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: #9ca3af;
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            color: #d1d5db;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            background: #111827;
            border: 1px solid #374151;
            border-radius: 8px;
            padding: 1rem;
            color: #ffffff;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-error {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .form-checkbox {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .form-checkbox input {
            margin-right: 0.5rem;
            accent-color: #3b82f6;
        }

        .form-checkbox label {
            color: #d1d5db;
            font-size: 0.9rem;
        }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: #ffffff;
            border: none;
            padding: 1rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        }

        .btn-login:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .alert-error {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: #ffffff;
        }

        /* Boxing gloves decoration */
        .boxing-decoration {
            position: absolute;
            top: 10%;
            right: 10%;
            width: 80px;
            height: 80px;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .boxing-decoration:nth-child(2) {
            top: 70%;
            left: 10%;
            animation-delay: -3s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-container {
                padding: 1rem;
            }

            .login-card {
                padding: 2rem 1.5rem;
            }

            .boxing-decoration {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Boxing gloves decorations -->
    <div class="boxing-decoration">
        <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full text-blue-500">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
        </svg>
    </div>
    <div class="boxing-decoration">
        <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full text-blue-500">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
        </svg>
    </div>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1>Boxing House PF</h1>
                <p>Entre com suas credenciais</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           class="form-input" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus 
                           placeholder="seu@email.com">
                    @error('email')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="form-input" 
                           required 
                           placeholder="Sua senha">
                </div>

                <div class="form-checkbox">
                    <input type="checkbox" id="remember" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">Lembrar-me</label>
                </div>

                <button type="submit" class="btn-login">
                    Entrar
                </button>
            </form>
        </div>
    </div>
</body>
</html>