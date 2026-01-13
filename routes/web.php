<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Professor\DashboardController as ProfessorDashboardController;
use App\Http\Controllers\Aluno\DashboardController as AlunoDashboardController;
use App\Http\Controllers\Professor\HorarioController;
use App\Http\Controllers\Professor\RegraController;
use App\Http\Controllers\Professor\ValorController;
use App\Http\Controllers\Professor\ConfigController;
use App\Http\Controllers\Professor\AprovacaoController;
use App\Http\Controllers\Professor\AlunoController;
use App\Http\Controllers\CadastroController;

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

    // Fluxo público de cadastro (3 etapas)
    Route::get('/cadastro', [CadastroController::class, 'step1'])->name('cadastro.step1');
    Route::post('/cadastro', [CadastroController::class, 'postStep1'])->name('cadastro.step1.post');
    Route::get('/cadastro/etapa-2', [CadastroController::class, 'step2'])->name('cadastro.step2');
    Route::post('/cadastro/etapa-2', [CadastroController::class, 'postStep2'])->name('cadastro.step2.post');
    Route::get('/cadastro/etapa-3', [CadastroController::class, 'step3'])->name('cadastro.step3');
    Route::post('/cadastro/etapa-3', [CadastroController::class, 'postStep3'])->name('cadastro.step3.post');
    Route::get('/cadastro/final', [CadastroController::class, 'final'])->name('cadastro.final');
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

    // Horários (CRUD básico)
    Route::resource('horarios', HorarioController::class);

    // Regras e Aceites (CRUD básico)
    Route::resource('regras', RegraController::class);

    // Valores (vezes por semana x preço)
    Route::resource('valores', ValorController::class);

    // Configurações (edição única)
    Route::get('config', [ConfigController::class, 'edit'])->name('config.edit');
    Route::put('config', [ConfigController::class, 'update'])->name('config.update');

    // Aprovações (listar pendentes e aprovar)
    Route::get('aprovacoes', [AprovacaoController::class, 'index'])->name('aprovacoes.index');
    Route::post('aprovacoes/{user}/aprovar', [AprovacaoController::class, 'aprovar'])
        ->name('aprovacoes.aprovar');

    // Alunos (listar, alterar senha, deletar)
    Route::get('alunos', [AlunoController::class, 'index'])->name('alunos.index');
    Route::post('alunos/{user}/senha', [AlunoController::class, 'alterarSenha'])->name('alunos.senha');
    Route::put('alunos/{user}/horarios', [AlunoController::class, 'atualizarHorarios'])->name('alunos.horarios');
    Route::delete('alunos/{user}', [AlunoController::class, 'destroy'])->name('alunos.destroy');
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
