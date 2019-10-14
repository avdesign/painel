<?php

/*
|--------------------------------------------------------------------------
| Autenticação de Usuários
|--------------------------------------------------------------------------
| Module:  admins crud
|--------------------------------------------------------------------------
*/
Route::resource('admins', 'Admin\Auth\RegisterController');
Route::put('admin/{id}/profile', 'Admin\Auth\RegisterController@updateProfile')->name('admin.profile.update');
Route::post('admins/data', 'Admin\Auth\RegisterController@data')->name('admins.data');

/*
|--------------------------------------------------------------------------
| Admins:  Admins excluded, modulos.
|--------------------------------------------------------------------------
*/
Route::post('admins/excluded/data', 'Admin\Auth\RegisterController@dataExcluded')->name('admins.excluded.data');
Route::get('admin/excluded', 'Admin\Auth\RegisterController@excludeds');
Route::post('admins/reactivate', 'Admin\Auth\RegisterController@reactivateExcluded')->name('admins.reactivate');
Route::get('admin/excluded/{id}/profile', 'Admin\AdminController@profileExcluded')->name('admin.excluded-profile');
Route::get('admin/excluded/{id}/access', 'Admin\AdminController@accessViewExcluded');
Route::get('admin/excluded/{id}/photo-admin', 'Admin\AdminController@photoAdminExcluded');
Route::delete('admin/excluded/{id}/photo-admin', 'Admin\ImageAdminController@photoDeleteExcluded')->name('photo-admin-excluded');

/*
|--------------------------------------------------------------------------
| Details:  Admins modulos.
|--------------------------------------------------------------------------
*/
Route::get('admin/{id}/profile', 'Admin\AdminController@profile')->name('admin.profile');
Route::get('admin/{id}/access', 'Admin\AdminController@accessView');
Route::post('admin/{id}/access', 'Admin\AdminController@accessActions')->name('admin.access.actions');
Route::get('admin/{id}/{mod}/modules', 'Admin\AdminController@getModules');
Route::get('admin/{id}/permissions/{idmod}/data', 'Admin\AdminController@permissions')->name('admin.permissions.data');
Route::put('admin/{id}/permission/update', 'Admin\AdminController@updatePermission')->name('admin.permission.update');

/*
|--------------------------------------------------------------------------
| Module:  Admins photos.
|--------------------------------------------------------------------------
*/
Route::resource('admin/{id}/photo-admin', 'Admin\ImageAdminController', ['except' => ['show']]);
Route::put('admin/status/{id}/photo', 'Admin\ImageAdminController@status')->name('photo-admin.status');
