<?php

use App\Http\Controllers\Auth\usuarioController;
use App\Http\Controllers\cliente\clienteController;
use App\Http\Controllers\condicaoPagamento\condicaoPagamentoController;
use App\Http\Controllers\consultas\consultasController;
use App\Http\Controllers\cotacao\cotacaoController;
use App\Http\Controllers\custoMp\custoMpController;
use App\Http\Controllers\custoOp\custoOpController;
use App\Http\Controllers\despesaFixa\despesaFixaController;
use App\Http\Controllers\empresa\empresaController;
use App\Http\Controllers\frete\freteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\menu\menuController;
use App\Http\Controllers\produto\produtoController;
use App\Http\Controllers\proposta\precificacaoController;
use App\Http\Controllers\proposta\propostaController;
use App\Http\Controllers\tabela\tabelaController;
use Illuminate\Support\Facades\Auth;


Auth::routes(['logout'=>false]);

Route::get('/', function () {
    return view('auth/login');
});

Route::group(['middleware' => ['auth']], function () {
    // Route::get('/',[HomeController::class,'index']);
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // Route::post('/home/atualizaCard', [HomeController::class, 'atualizaCard'])->name('atualizaCard');

    Route::get('/public', [HomeController::class, 'index']);
    Route::post('/logout', [HomeController::class, 'logout'])->name('logout');

    /********************************** menu ***************************************************************/
    Route::group(['namespace' => 'menu'], function () {
        Route::get('menu',[menuController::class,'listAllmenu'])->name('menu.listAll')->middleware('nivel');
        Route::get('menu/novo',[menuController::class,'formAddmenu'])->name('menu.formAddmenu');
        Route::get('menu/editar/{menu}',[menuController::class,'formEditmenu'])->name('menu.formEditmenu');
        Route::post('menu/store',[menuController::class,'stroremenu'])->name('menu.store');
        Route::patch('menu/edit/{menu}',[menuController::class,'edit'])->name('menu.edit');
        Route::delete('menu/destroy/{menu}',[menuController::class,'destroy'])->name('menu.destroy');

        Route::get('menu/menuUsuario',[MenuController::class,'menuUsuario'])->name('menu.menuUsuario');
        Route::post('menu/disponivel',[MenuController::class,'disponivel'])->name('menu.disponivel');
        Route::post('menu/menuLiberado',[MenuController::class,'menuLiberado'])->name('menu.menuLiberado');

        Route::post('menu/addMenuUsuario',[MenuController::class,'addMenuUsuario'])->name('menu.addMenuUsuario');
        Route::post('menu/removeMenuUsuario',[MenuController::class,'removeMenuUsuario'])->name('menu.removeMenuUsuario');

    });
    /********************************** usuario ***************************************************************/
    Route::group(['namespace' => 'usuario'], function () {
        Route::get('usuario',[usuarioController::class,'listAll'])->name('usuario.listAll')->middleware('nivel');
        Route::get('usuario/edit/{usuario}',[usuarioController::class,'formEdit'])->name('usuario.formEdit');
        Route::post('usuario/ativaUsuario',[usuarioController::class,'ativaUsuario'])->name('usuario.ativaUsuario');
        Route::post('usuario/nivelUsuario',[usuarioController::class,'nivelUsuario'])->name('usuario.nivelUsuario');
        Route::post('usuario/etapalUsuario',[usuarioController::class,'etapalUsuario'])->name('usuario.etapalUsuario');

        Route::post('usuario/updateSenha',[usuarioController::class,'updateSenha'])->name('usuario.updateSenha');
    });

    /********************************** empresa ***************************************************************/
    Route::group(['namespace' => 'empresa'], function () {
        Route::get('empresa',[empresaController::class,'listAll'])->name('empresa.listAll');
        Route::get('empresa/novo',[empresaController::class,'formAdd'])->name('empresa.formAdd');
        Route::get('empresa/editar/{id}',[empresaController::class,'formEdit'])->name('empresa.formEdit');
        Route::post('empresa/store',[empresaController::class,'store'])->name('empresa.store');
        Route::patch('empresa/edit/{id}',[empresaController::class,'edit'])->name('empresa.edit');
        Route::delete('empresa/destroy/{id}',[empresaController::class,'destroy'])->name('empresa.destroy');

        Route::post('empresa/buscaCep',[empresaController::class,'buscaCep'])->name('empresa.buscaCep');
        Route::post('empresa/buscaCnpj',[empresaController::class,'buscaCnpj'])->name('empresa.buscaCnpj');

    });

        /********************************** cliente ***************************************************************/
    Route::group(['namespace' => 'cliente'], function () {
        Route::get('cliente',[clienteController::class,'listAll'])->name('cliente.listAll');
        Route::get('cliente/novo',[clienteController::class,'formAdd'])->name('cliente.formAdd');
        Route::get('cliente/editar/{cliente}',[clienteController::class,'formEdit'])->name('cliente.formEdit');
        Route::post('cliente/store',[clienteController::class,'store'])->name('cliente.store');
        Route::patch('cliente/edit/{cliente}',[clienteController::class,'edit'])->name('cliente.edit');
        Route::delete('cliente/destroy/{cliente}',[clienteController::class,'destroy'])->name('cliente.destroy');

        Route::post('cliente/buscaCep',[clienteController::class,'buscaCep'])->name('cliente.buscaCep');
        Route::post('cliente/buscaCnpj',[clienteController::class,'buscaCnpj'])->name('cliente.buscaCnpj');

        Route::post('cliente/verificaNaBase',[clienteController::class,'verificaNaBase'])->name('cliente.verificaNaBase');

    });

    /********************************** proposta ***************************************************************/
    Route::group(['namespace' => 'proposta'], function () {
        Route::get('proposta',[propostaController::class,'listAll'])->name('proposta.listAll');
        Route::get('proposta/novo',[propostaController::class,'formAdd'])->name('proposta.formAdd');
        Route::get('proposta/editar/{id}',[propostaController::class,'formEdit'])->name('proposta.formEdit');
        Route::post('proposta/store',[propostaController::class,'store'])->name('proposta.store');
        Route::patch('proposta/edit/{proposta}',[propostaController::class,'edit'])->name('proposta.edit');
        Route::delete('proposta/destroy/{proposta}',[propostaController::class,'destroy'])->name('proposta.destroy');


        Route::post('proposta/bg_localizaProduto',[propostaController::class,'bg_localizaProduto'])->name('proposta.bg_localizaProduto');
        Route::post('proposta/localizaNomeProduto',[propostaController::class,'localizaNomeProduto'])->name('proposta.localizaNomeProduto');

        Route::post('proposta/insereItens',[propostaController::class,'insereItens'])->name('contabilidade.insereItens');

        Route::post('proposta/bg_localizaCliente',[propostaController::class,'bg_localizaCliente'])->name('proposta.bg_localizaCliente');
        Route::post('proposta/localizaNomeCliente',[propostaController::class,'localizaNomeCliente'])->name('proposta.localizaNomeCliente');
    });

    /********************************** precificacao ***************************************************************/
    Route::group(['namespace' => 'precificacao'], function () {
        Route::get('precificacao',[precificacaoController::class,'listAll'])->name('precificacao.listAll');
        Route::get('precificacao/precificar/{id}',[precificacaoController::class,'formPrecificacao'])->name('precificacao.formPrecificacao');
        Route::patch('precificacao/editPrecificacao/{id}',[precificacaoController::class,'editPrecificacao'])->name('precificacao.editPrecificacao');
        Route::post('precificacao/alteraEmpresa',[precificacaoController::class,'alteraEmpresa'])->name('precificacao.alteraEmpresa');
    });

});
