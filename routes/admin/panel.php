<?php

/*
|--------------------------------------------------------------------------
| Autenticação de Usuários
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'Admin\PainelController@index')->name('painel');
    Route::get('home', 'Admin\PainelController@home');

});
Route::get('error{code}', 'Admin\PainelController@error')->name('error');

Route::get('menu', 'Admin\PainelController@menu');
