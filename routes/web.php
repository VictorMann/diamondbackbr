<?php

use Illuminate\Support\Facades\DB;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');
Route::get('diamondback', 'DiamondbackController@index')->name('diamondbacks.index');
Route::get('p/{slug}', 'ProdutoController@show')->name('produtos.show');
Route::get('seja-um-revendedor', 'LojaController@revendedor')->name('lojas.revendedor');
Route::get('encontre-uma-loja', 'LojaController@lojas')->name('lojas.encontre');
Route::get('encontre-uma-loja/{estado}', 'LojaController@lojasPorEstado')->name('lojas.estado');
Route::get('garantia', 'GarantiaController@index')->name('garantias.index');
Route::get('contato', 'ContatoController@index')->name('contatos.index');
Route::post('contato', 'ContatoController@send')->name('contatos.send');
Route::get('search', 'SearchController@index')->name('search.index');
Route::get('{categoria}', 'ProdutoController@index')->name('produtos.index');

// newsletter
Route::get('cadastro/newsletter', function (Illuminate\Http\Request $req) {

    $exist = DB::table('newsletters')->where('email', $req->input('email'))->first();
    if (!$exist) DB::table('newsletters')->insert(['email' => $req->input('email')]);
    return $exist ? 'existente' : 'adicionado';
});

// api
Route::get('api/revendas-per-estado', 'LojaController@listRevPerEstJson');