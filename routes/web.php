<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Professor\DashboardController as ProfessorDashboardController;
use App\Http\Controllers\Aluno\DashboardController as AlunoDashboardController;
use App\Http\Controllers\Aluno\RegrasController as AlunoRegrasController;
use App\Http\Controllers\Aluno\PerfilController as AlunoPerfilController;
use App\Http\Controllers\Aluno\MeusHorariosController as AlunoMeusHorariosController;
use App\Http\Controllers\Publico\LandingController;
use App\Http\Controllers\Professor\HorarioController;
use App\Http\Controllers\Professor\RegraController;
use App\Http\Controllers\Professor\ValorController;
use App\Http\Controllers\Professor\ConfigController;
use App\Http\Controllers\Professor\AprovacaoController;
use App\Http\Controllers\Professor\AlunoController;
use App\Http\Controllers\Professor\TreinoController;
use App\Http\Controllers\Professor\AulaSequenciaController;
use App\Http\Controllers\Professor\ProfessorController;
use App\Http\Controllers\Professor\AppController;
use App\Http\Controllers\Professor\AvaliacaoController;
use App\Http\Controllers\Publico\CadastroController;
use App\Http\Controllers\Publico\LandingController as PublicoLandingController;
use App\Http\Controllers\Aluno\AnotacoesController as AlunoAnotacoesController;
use App\Http\Controllers\Aluno\TreinosController as AlunoTreinosController;
use App\Http\Controllers\Aluno\AvaliarController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Rotas principais da aplicação Boxing House PF
| Sistema de academia de boxe com duas frentes: Professor e Aluno
|
*/

// Rota raiz - Redireciona para dashboard se logado, senão mostra landing page
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        return $user->role === 'professor' 
            ? redirect()->route('professor.dashboard')
            : redirect()->route('aluno.dashboard');
    }
    
    return app(LandingController::class)->index();
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

    // Horários (CRUD básico)
    Route::resource('horarios', HorarioController::class);

    // Regras e Aceites (CRUD básico)
    Route::resource('regras', RegraController::class);

    // Valores (vezes por semana x preço)
    Route::resource('valores', ValorController::class);

    // Configurações (edição única)
    Route::get('config', [ConfigController::class, 'edit'])->name('config.edit');
    Route::put('config', [ConfigController::class, 'update'])->name('config.update');
    Route::post('config/fotos', [ConfigController::class, 'adicionarFoto'])->name('config.fotos.store');
    Route::delete('config/fotos/{foto}', [ConfigController::class, 'excluirFoto'])->name('config.fotos.destroy');

    // Aprovações (listar pendentes e aprovar)
    Route::get('aprovacoes', [AprovacaoController::class, 'index'])->name('aprovacoes.index');
    Route::post('aprovacoes/{user}/aprovar', [AprovacaoController::class, 'aprovar'])
        ->name('aprovacoes.aprovar');

    // Alunos (listar, alterar senha, deletar)
    Route::get('alunos', [AlunoController::class, 'index'])->name('alunos.index');
    Route::post('alunos/{user}/senha', [AlunoController::class, 'alterarSenha'])->name('alunos.senha');
    Route::put('alunos/{user}/horarios', [AlunoController::class, 'atualizarHorarios'])->name('alunos.horarios');
    Route::delete('alunos/{user}', [AlunoController::class, 'destroy'])->name('alunos.destroy');

    // Treinos (CRUD básico com foto e presença de alunos)
    Route::resource('treinos', TreinoController::class);

    // Sequência de Aulas (CRUD)
    Route::resource('aulas-sequencia', AulaSequenciaController::class)->parameters([
        'aulas-sequencia' => 'sequencia'
    ]);

    // Professor (dados pessoais do professor)
    Route::get('professor', [ProfessorController::class, 'edit'])->name('professor.edit');
    Route::put('professor', [ProfessorController::class, 'update'])->name('professor.update');
    Route::post('professor/remover-imagem', [ProfessorController::class, 'removerImagem'])->name('professor.remover-imagem');

    // App - Sistema do Aluno
    Route::get('app', [AppController::class, 'index'])->name('app.index');
    Route::put('app', [AppController::class, 'update'])->name('app.update');
    Route::post('app/remover-imagem', [AppController::class, 'removerImagem'])->name('app.remover-imagem');

    // Avaliacões dos Alunos
    Route::get('avaliacoes', [AvaliacaoController::class, 'index'])->name('avaliacoes.index');
    Route::post('avaliacoes/{avaliacao}/aprovar', [AvaliacaoController::class, 'aprovar'])->name('avaliacoes.aprovar');
    Route::post('avaliacoes/{avaliacao}/reprovar', [AvaliacaoController::class, 'reprovar'])->name('avaliacoes.reprovar');
    Route::delete('avaliacoes/{avaliacao}', [AvaliacaoController::class, 'destroy'])->name('avaliacoes.destroy');
});

/*
|--------------------------------------------------------------------------
| Rotas do Aluno
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:aluno'])->prefix('aluno')->name('aluno.')->group(function () {
    Route::get('/dashboard', [AlunoDashboardController::class, 'index'])->name('dashboard');
    
    // Regras do CT
    Route::get('regras', [AlunoRegrasController::class, 'index'])->name('regras');

    // Meu Perfil
    Route::get('perfil', [AlunoPerfilController::class, 'edit'])->name('perfil');
    Route::put('perfil', [AlunoPerfilController::class, 'update'])->name('perfil.update');

    // Meus Horários
    Route::get('horarios', [AlunoMeusHorariosController::class, 'index'])->name('horarios');
    Route::put('horarios', [AlunoMeusHorariosController::class, 'update'])->name('horarios.update');

    // Meus Treinos
    Route::get('treinos', [\App\Http\Controllers\Aluno\TreinosController::class, 'index'])->name('treinos');

    // Minhas Anotações
    Route::get('anotacoes', [AlunoAnotacoesController::class, 'index'])->name('anotacoes.index');
    Route::post('anotacoes', [AlunoAnotacoesController::class, 'store'])->name('anotacoes.store');
    Route::put('anotacoes/{anotacao}', [AlunoAnotacoesController::class, 'update'])->name('anotacoes.update');
    Route::delete('anotacoes/{anotacao}', [AlunoAnotacoesController::class, 'destroy'])->name('anotacoes.destroy');

    // Avaliar
    Route::get('avaliar', [AvaliarController::class, 'index'])->name('avaliar.index');
    Route::post('avaliar', [AvaliarController::class, 'store'])->name('avaliar.store');
    Route::post('avaliar/remover-foto', [AvaliarController::class, 'removerFoto'])->name('avaliar.remover-foto');
});
