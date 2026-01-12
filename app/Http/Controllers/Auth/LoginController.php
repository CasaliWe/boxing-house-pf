<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Exibe o formulário de login
     */
    public function showLoginForm()
    {
        // Se já está logado, redireciona para dashboard apropriado
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }

        return view('auth.login');
    }

    /**
     * Processa o login do usuário
     */
    public function login(Request $request)
    {
        try {
            // Validação dos dados
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);

            // Tentativa de autenticação
            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();
                
                Log::info('Login realizado com sucesso', [
                    'user_id' => Auth::id(),
                    'email' => Auth::user()->email,
                    'role' => Auth::user()->role
                ]);

                return $this->redirectToDashboard();
            }

            // Login falhou
            throw ValidationException::withMessages([
                'email' => 'As credenciais informadas não conferem com nossos registros.',
            ]);

        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Erro no processo de login', [
                'error' => $e->getMessage(),
                'email' => $request->email
            ]);

            return back()->withErrors([
                'email' => 'Ocorreu um erro interno. Tente novamente.'
            ]);
        }
    }

    /**
     * Logout do usuário
     */
    public function logout(Request $request)
    {
        try {
            Log::info('Logout realizado', [
                'user_id' => Auth::id(),
                'email' => Auth::user()->email
            ]);

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login');

        } catch (\Exception $e) {
            Log::error('Erro no logout', ['error' => $e->getMessage()]);
            return redirect()->route('login');
        }
    }

    /**
     * Redireciona para o dashboard baseado na role do usuário
     */
    private function redirectToDashboard()
    {
        $user = Auth::user();
        
        return $user->role === 'professor' 
            ? redirect()->route('professor.dashboard')
            : redirect()->route('aluno.dashboard');
    }
}
