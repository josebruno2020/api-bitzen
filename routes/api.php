<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth'], function () {
    

    Route::group(['prefix' => 'filmes'], function () {
        
        Route::get('', 'FilmeController@index');
        Route::post('', 'FilmeController@store');
        Route::get('/{id}', 'FilmeController@show');
        Route::put('/{id}', 'FilmeController@update');
        Route::delete('/{id}', 'FilmeController@destroy');
        
        Route::post('/{id}/categoria/{id_categoria}', 'FilmeController@categorizar');
        Route::post('/{id}/ator/{id_ator}', 'FilmeController@colocarAtor');
        Route::post('/avaliar/{id}', 'FilmeController@avaliar');
        Route::get('/{id}/atores', 'FilmeController@atoresFilme');
        Route::get('/{id}/categorias', 'FilmeController@categoriasFilme');
        
    });

    Route::post('/buscar', 'FilmeController@search');
    Route::get('/top-avaliados', 'FilmeController@topAvaliados');

    Route::group(['prefix' => 'categorias'], function () {
        Route::get('', 'CategoriaController@index');
        Route::post('', 'CategoriaController@store');
        Route::get('/{id}', 'CategoriaController@show');
        Route::put('/{id}', 'CategoriaController@update');
        Route::delete('/{id}', 'CategoriaController@destroy');

        Route::get('/{id}/filmes', 'CategoriaController@filmesDaCategoria');
    });
    
    Route::group(['prefix' => 'atores'], function () {
        Route::get('', 'AtorController@index');
        Route::post('', 'AtorController@store');
        Route::get('/{id}', 'AtorController@show');
        Route::put('/{id}', 'AtorController@update');
        Route::delete('/{id}', 'AtorController@destroy');

        Route::get('/{id}/filmes', 'AtorController@filmesDoAtor');
    });
    
    Route::group(['prefix' => 'usuarios'], function () {
        Route::get('', 'UserController@index');
        Route::get('/{id}', 'UserController@show');
        Route::put('/{id}', 'UserController@update');
        Route::delete('/{id}', 'UserController@destroy');
    });

});
Route::post('/usuarios', 'UserController@store');

Route::post('login', 'TokenController@login');

