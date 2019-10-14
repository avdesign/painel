<?php

/*
|--------------------------------------------------------------------------
| Autenticação dos usuários administrativos
|--------------------------------------------------------------------------
*/

Route::get('/login', 'Admin\Auth\LoginController@showLoginForm')->name('login');
Route::get('/', 'Admin\Auth\LoginController@showLoginForm')->name('admin.login');
Route::post('/', 'Admin\Auth\LoginController@login')->name('admin.login');
Route::get('logout', 'Admin\Auth\LoginController@logout')->name('admin.logout');
Route::post('logout', 'Admin\Auth\LoginController@logout')->name('admin.logout');

// Recuperar senha
Route::post('password/email', 'Admin\Auth\RegisterController@sendResetLinkEmail')->name('admin.password.email');
Route::get('recuperar/{id}/senha', 'Admin\Auth\RegisterController@showLinkRequestForm')->name('admin.password.request');
Route::post('password/reset', 'Admin\Auth\ResetPasswordController@reset');
Route::get('password/reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');

