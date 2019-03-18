<?php

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
Route::get('cadastro/newsletter', 'HomeController@cadastroNewsletter')->name('cadastro-newsletter');
Route::get('diamondback', 'DiamondbackController@index')->name('diamondbacks.index');
Route::get('p/{slug}', 'ProdutoController@show')->name('produtos.show');
Route::get('seja-um-revendedor', 'LojaController@revendedor')->name('lojas.revendedor');
Route::get('encontre-uma-loja', 'LojaController@lojas')->name('lojas.encontre');
Route::get('encontre-uma-loja/{estado}', 'LojaController@lojasPorEstado')->name('lojas.estado');
Route::get('garantia', 'GarantiaController@index')->name('garantias.index');
Route::get('contato', 'ContatoController@index')->name('contatos.index');
Route::post('contato', 'ContatoController@send')->name('contatos.send');
Route::get('search', 'SearchController@index')->name('search.index');

// admin
Auth::routes(['register' => false]);
Route::get('logout', 'AdminController@logout')->name('logout');
Route::put('alter-password', 'AdminController@alterPassword')->name('alter-password');
Route::get('dashboard', 'AdminController@index')->name('dashboard');
Route::post('admin/produtos', 'AdminController@store')->name('produtos.store');
Route::get('admin/produtos/create', 'AdminController@create')->name('produtos.create');
Route::get('admin/produtos/{id}/edit', 'AdminController@edit')->name('produtos.edit');
Route::put('admin/produtos/{id}', 'AdminController@update')->name('produtos.update');
Route::delete('admin/produtos/{id}', 'AdminController@destroy')->name('produtos.destroy');
Route::get('carrossel', 'AdminController@carrIndex')->name('carrossel');
Route::post('carrossel', 'AdminController@carrUpdate')->name('carrossel.update');


Route::get('{categoria}', 'ProdutoController@index')->name('produtos.index');


// api
Route::get('api/revendas-per-estado', 'LojaController@listRevPerEstJson');