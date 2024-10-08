<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LancamentosController;
use App\Http\Controllers\MoedasController;
use App\Http\Controllers\SolicitacoesController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\TransferController;
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
})->name('/');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['admin'])->group(function () {
    #status
    Route::get('/status', [StatusController::class, 'index'])->name('status.index');
    Route::post('/status', [StatusController::class, 'store'])->name('status.store');
    Route::put('/status/{id}', [StatusController::class, 'update'])->name('status.update');
    Route::delete('/status/{id}', [StatusController::class, 'destroy'])->name('status.destroy');

    #tipo
    Route::get('/tipo', [TipoController::class, 'index'])->name('tipo.index');
    Route::post('/tipo', [TipoController::class, 'store'])->name('tipo.store');
    Route::put('/tipo/{id}', [TipoController::class, 'update'])->name('tipo.update');
    Route::delete('/tipo/{id}', [TipoController::class, 'destroy'])->name('tipo.destroy');

    #moedas
    Route::get('/moedas', [MoedasController::class, 'index'])->name('moedas.index');
    Route::post('/moedas', [MoedasController::class, 'store'])->name('moedas.store');
    Route::put('/moedas/{id}', [MoedasController::class, 'update'])->name('moedas.update');
    Route::delete('/moedas/{id}', [MoedasController::class, 'destroy'])->name('moedas.destroy');

    #usuarios
    Route::get('/usuario', [UserController::class, 'index'])->name('usuario.index');
    Route::post('/usuario', [UserController::class, 'store'])->name('usuario.store');
    Route::put('/usuario/{id}', [UserController::class, 'update'])->name('usuario.update');
    Route::delete('/usuario/{id}', [UserController::class, 'destroy'])->name('usuario.destroy');

    #lançamentos
    Route::post('/lancamentos/reserva', [App\Http\Controllers\LancamentosController::class, 'reserva'])->name('lancamentos.reserva');
    Route::get('/lancamento/liberar', [LancamentosController::class, 'listaLiberar'])->name('lancamento.liberar');
    Route::get('/lancamento/controle', [LancamentosController::class, 'controle'])->name('lancamento.controle');
    Route::post('/lancamentos/update-status', [LancamentosController::class, 'updateStatus'])->name('lancamentos.update-status');
    Route::post('/lancamentos/update-status3', [LancamentosController::class, 'updateStatus3'])->name('lancamentos.update-status3');
    Route::put('/lancamento/{id}', [LancamentosController::class, 'update'])->name('lancamento.update');
    Route::delete('/lancamento/{id}', [LancamentosController::class, 'destroy'])->name('lancamento.destroy');
    Route::get('/lancamento', [LancamentosController::class, 'index'])->name('lancamento.index');
    Route::get('/Listalancamento', [LancamentosController::class, 'indexLista'])->name('lancamento.indexLista');
    Route::post('/lancamento', [LancamentosController::class, 'store'])->name('lancamento.store');
    Route::post('/lancamentos/updatestatus', [App\Http\Controllers\LancamentosController::class, 'updateStatus2'])->name('lancamentos.update-status2');

    #transferencia
    Route::get('/transferencia', [TransferController::class, 'index2'])->name('transferencia.index2');
}); 
#Dashboard
Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');

#lançamentos
Route::get('/lancamento/usuario', [LancamentosController::class, 'listaUser'])->name('lancamento.usuario');
Route::post('/lancamentos/update-status4', [LancamentosController::class, 'updateStatus4'])->name('lancamentos.update-status4');
Route::post('/lancamentos/update-status1', [LancamentosController::class, 'updateStatus1'])->name('lancamentos.update-status1');
Route::get('/lancamentos/exportar-selecionados-excel', [LancamentosController::class, 'exportarSelecionadosParaExcel'])->name('exportar.lancamentos.selecionados.excel');


#solicitação
Route::get('/solicitacoes', [SolicitacoesController::class, 'index'])->name('solicitacoes.lista');
Route::put('/solicitacoes/{id}', [SolicitacoesController::class, 'update'])->name('solicitacoes.update');
Route::delete('/solicitacoes/{solicitacao}', [SolicitacoesController::class, 'destroy'])->name('solicitacoes.destroy');
Route::get('/solicitacoes/criar', [SolicitacoesController::class, 'criar'])->name('solicitacoes.criar');
Route::post('/solicitacoes', [SolicitacoesController::class, 'store'])->name('solicitacoes.store');
Route::post('/solicitacoes2', [SolicitacoesController::class, 'store2'])->name('solicitacoes.store2');
Route::get('/solicitacoes/{id}/lancamentos', [SolicitacoesController::class, 'getLancamentos']);
Route::post('/solicitacoes/updateStatus/{id}', [SolicitacoesController::class, 'updateStatus'])->name('solicitacoes.updateStatus');




Route::get('/transferencia/user', [TransferController::class, 'index'])->name('transferencia.index');
Route::post('/transferencia/user', [TransferController::class, 'store'])->name('transferencia.store');

Route::get('/buscar', [TransferController::class, 'index3'])->name('buscar');

Route::get('/qrcode/{address}', [TransferController::class, 'generateQRCode'])->name('qrcode.generate');
