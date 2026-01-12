<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Professor\DashboardController as ProfessorDashboardController;
use App\Http\Controllers\Aluno\DashboardController as AlunoDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Rotas principais da aplicação Boxing House PF
| Sistema de academia de boxe com duas frentes: Professor e Aluno
|
*/

// Rota raiz - Landing page (futura implementação)
Route::get('/', function () {
    // Se estiver autenticado, redireciona para dashboard apropriado
    if (auth()->check()) {
        return auth()->user()->role === 'professor' 
            ? redirect()->route('professor.dashboard')
            : redirect()->route('aluno.dashboard');
    }
    
    // Por enquanto redireciona para login, depois será a landing page
    return redirect()->route('login');
})->name('home');

/*
|--------------------------------------------------------------------------
| Rotas de Autenticação
|--------------------------------------------------------------------------
*/

// Rotas de login (acesso público)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Logout (apenas usuários autenticados)
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Rotas do Professor
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:professor'])->prefix('professor')->name('professor.')->group(function () {
    Route::get('/dashboard', [ProfessorDashboardController::class, 'index'])->name('dashboard');
    
    // Futuras rotas do professor
    // Route::resource('alunos', AlunoController::class);
    // Route::resource('treinos', TreinoController::class);
    // Route::get('relatorios', [RelatorioController::class, 'index'])->name('relatorios');
});

/*
|--------------------------------------------------------------------------
| Rotas do Aluno
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:aluno'])->prefix('aluno')->name('aluno.')->group(function () {
    Route::get('/dashboard', [AlunoDashboardController::class, 'index'])->name('dashboard');
    
    // Futuras rotas do aluno
    // Route::get('treinos', [TreinoController::class, 'meusTreeinos'])->name('treinos');
    // Route::get('perfil', [PerfilController::class, 'edit'])->name('perfil');
    // Route::get('historico', [HistoricoController::class, 'index'])->name('historico');
});
