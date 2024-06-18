<?php

use App\Http\Controllers\LancamentosController;
use App\Http\Controllers\MoedasController;
use App\Http\Controllers\SolicitacoesController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// status
Route::get('/status', [StatusController::class, 'index'])->name('status.index');
Route::post('/status', [StatusController::class, 'store'])->name('status.store');
Route::put('/status/{id}', [StatusController::class, 'update'])->name('status.update');
Route::delete('/status/{id}', [StatusController::class, 'destroy'])->name('status.destroy');

// tipo
Route::get('/tipo', [TipoController::class, 'index'])->name('tipo.index');
Route::post('/tipo', [TipoController::class, 'store'])->name('tipo.store');
Route::put('/tipo/{id}', [TipoController::class, 'update'])->name('tipo.update');
Route::delete('/tipo/{id}', [TipoController::class, 'destroy'])->name('tipo.destroy');

// moedas
Route::get('/moedas', [MoedasController::class, 'index'])->name('moedas.index');
Route::post('/moedas', [MoedasController::class, 'store'])->name('moedas.store');
Route::put('/moedas/{id}', [MoedasController::class, 'update'])->name('moedas.update');
Route::delete('/moedas/{id}', [MoedasController::class, 'destroy'])->name('moedas.destroy');

// usuarios
Route::get('/usuario', [UserController::class, 'index'])->name('usuario.index');
Route::post('/usuario', [UserController::class, 'store'])->name('usuario.store');
Route::put('/usuario/{id}', [UserController::class, 'update'])->name('usuario.update');
Route::delete('/usuario/{id}', [UserController::class, 'destroy'])->name('usuario.destroy');

// usuarios
Route::get('/lancamento', [LancamentosController::class, 'index'])->name('lancamento.index');
Route::post('/lancamento', [LancamentosController::class, 'store'])->name('lancamento.store');
Route::put('/lancamento/{id}', [LancamentosController::class, 'update'])->name('lancamento.update');
Route::delete('/lancamento/{id}', [LancamentosController::class, 'destroy'])->name('lancamento.destroy');
Route::post('/lancamentos/update-status', [LancamentosController::class, 'updateStatus'])->name('lancamentos.update-status');
Route::get('/lancamento/controle', [LancamentosController::class, 'controle'])->name('lancamento.controle');
Route::get('/lancamento/usuario', [LancamentosController::class, 'listaUser'])->name('lancamento.usuario');
Route::post('/lancamentos/update-status1', [LancamentosController::class, 'updateStatus1'])->name('lancamentos.update-status1');
Route::get('/lancamentos/exportar-selecionados-excel', [LancamentosController::class, 'exportarSelecionadosParaExcel'])->name('exportar.lancamentos.selecionados.excel');

Route::get('/lancamento/liberar', [LancamentosController::class, 'listaLiberar'])->name('lancamento.liberar');

#solicitaçao
Route::get('/solicitacoes', [SolicitacoesController::class, 'index'])->name('solicitacoes.lista');
Route::get('/solicitacoes/criar', [SolicitacoesController::class, 'criar'])->name('solicitacoes.criar');
Route::post('/solicitacoes', [SolicitacoesController::class, 'store'])->name('solicitacoes.store');
Route::put('/solicitacoes/{id}', [SolicitacoesController::class, 'update'])->name('solicitacoes.update');
Route::delete('/solicitacoes/{solicitacao}', [SolicitacoesController::class, 'destroy'])->name('solicitacoes.destroy');