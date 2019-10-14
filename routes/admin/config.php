<?php

/*
|--------------------------------------------------------------------------
| Configurações do sistema
|--------------------------------------------------------------------------
*/

// Cores do sistema
Route::get('config/system', 'Admin\ConfigController@index');
Route::get('config/color/system', 'Admin\ConfigController@colorSystem')->name('config.colors');
Route::put('config/color/system', 'Admin\ConfigController@colorUpdate')->name('config.colors.update');
Route::get('config/folders/{name}', 'Admin\ConfigController@folders');

// Palavras chaves (keywords).
Route::post('config/keywords/data', 'Admin\ConfigKeywordsController@data')->name('keywords.data');
Route::resource('config/keywords', 'Admin\ConfigKeywordsController');

// Kits (Caixa, Pacote etc)
Route::post('config/kits/data', 'Admin\ConfigKitController@data')->name('config.kits.data');
Route::resource('config/kits', 'Admin\ConfigKitController');

// Modulos vinculados ao produto.
Route::get('config/{id}/freights', 'Admin\ConfigFreightController@edit');
Route::put('config/fretes/{id}/update', 'Admin\ConfigFreightController@update')->name('config.freight.update');

// Modulos vinculados ao produto.
Route::get('config/{id}/products', 'Admin\ConfigProductController@edit');
Route::put('config/products/{id}/update', 'Admin\ConfigProductController@update')->name('config.products.update');

// Modulos vinculados ao site.
Route::get('config/{id}/site', 'Admin\ConfigSiteController@edit', ['except' => ['edit']]);
Route::put('config/site/{id}/update', 'Admin\ConfigSiteController@update')->name('config.site.update');

// Config Page Site
Route::resource('config/page-site', 'Admin\ConfigPageController');
Route::get('config/page-site-load', 'Admin\ConfigPageController@load')->name('page-site-load');
// Config Templates Site
Route::resource('config/template-site', 'Admin\ConfigTemplateController');

// Modulos do sistema
Route::resource('config/modules', 'Admin\ConfigModuleController');
Route::post('config/modules/data', 'Admin\ConfigModuleController@data')->name('module.data');
Route::post('config/modules/{id}/permissions', 'Admin\ConfigModuleController@showPermissions')->name('module.permissions.show');

// Perfis dos Usuários
Route::post('config/profiles/data', 'Admin\ConfigProfileController@data')->name('profile.data');
Route::post('config/profiles/{id}/users', 'Admin\ConfigProfileController@showUsers')->name('profile.users.show');
Route::get('config/profiles/{id}/users/criar', 'Admin\ConfigProfileController@createUsers')->name('profile.users.create');
Route::post('config/profiles/{id}/users/criar', 'Admin\ConfigProfileController@storeUsers')->name('profile.users.store');
Route::post('config/profiles/{id}/user/{iduser}listar', 'Admin\ConfigProfileController@listPerfis')->name('profile.users.list');
Route::delete('config/profiles/{id}/user/{iduser}/excluir', 'Admin\ConfigProfileController@deleteUser')->name('profile.users.delete');
Route::resource('config/profiles', 'Admin\ConfigProfileController');

// Permissões dos Usuários
Route::post('config/permissions/data', 'Admin\ConfigPermissionController@data')->name('permission.data');
Route::post('config/permissions/{id}/perfis', 'Admin\ConfigPermissionController@showProfiles')->name('permission.profile.show');
Route::get('config/permissions/{id}/perfis/criar', 'Admin\ConfigPermissionController@createProfile')->name('permission.profile.create');
Route::post('config/permissions/{id}/perfis/criar', 'Admin\ConfigPermissionController@storeProfiles')->name('permission.profile.store');
Route::delete('config/permissions/{id}/perfis/{idper}/excluir', 'Admin\ConfigPermissionController@deleteProfile')->name('permission.profile.delete');
Route::resource('config/permissions', 'Admin\ConfigPermissionController');


// Config images brands.
Route::get('config/images/brands', 'Admin\ConfigBrandController@edit');
Route::put('config/images/{id}/brands', 'Admin\ConfigBrandController@update')->name('config.brand.update');

// Config images sections.
Route::get('config/images/sections', 'Admin\ConfigSectionController@edit');
Route::put('config/images/{id}/sections', 'Admin\ConfigSectionController@update')->name('config.section.update');

// Config images categories.
Route::get('config/images/categories', 'Admin\ConfigCategoryController@edit');
Route::put('config/images/{id}/categories', 'Admin\ConfigCategoryController@update')->name('config.category.update');

// Config images products.
Route::post('config/colors-positions/data', 'Admin\ConfigColorPositionController@data')->name('config.colors-positions.data');
Route::resource('config/colors-positions', 'Admin\ConfigColorPositionController');

// Config images admins.
Route::get('config/images/admins', 'Admin\ConfigAdminController@edit');
Route::put('config/images/{id}/admins', 'Admin\ConfigAdminController@update')->name('config.images-admin.update');

// Config imagens  slider da home
Route::get('config/images/slider', 'Admin\ConfigSliderController@edit');
Route::put('config/images/{id}/slider', 'Admin\ConfigSliderController@update')->name('config.slider.update');

// Config images  banners
Route::get('config/images/banners', 'Admin\ConfigBannerController@edit');
Route::put('config/images/{id}/banners', 'Admin\ConfigBannerController@update')->name('config.banners.update');

//Config Group Colors.
Route::resource('config/grupo-colors', 'Admin\ConfigColorGroupController');

//Config message.
Route::resource('config/contact-subjects', 'Admin\ConfigSubjectContactController');
Route::get('config/contact-subjects-load', 'Admin\ConfigSubjectContactController@loadSubjects')->name('contact-subjects.load');

//Config Forma de Pagamentos.
Route::resource('config/forms-payments', 'Admin\ConfigFormPaymentController');
Route::get('config/form/payments/excluded', 'Admin\ConfigFormPaymentController@excluded')->name('forms-payments.excluded');
Route::get('config/form/payments/{id}/reactivate', 'Admin\ConfigFormPaymentController@reactivate')->name('forms-payments.reactivate');

//Config Status Pagamento.
Route::resource('config/status-payments', 'Admin\ConfigStatusPaymentController');
Route::get('config/status/payments/excluded', 'Admin\ConfigStatusPaymentController@excluded')->name('status.payments.excluded');
Route::get('config/status/payments/{id}/reactivate', 'Admin\ConfigStatusPaymentController@reactivate')->name('status.payments.reactivate');

// Config unidade de medida.
Route::post('config/units-measures/data', 'Admin\ConfigUnitMeasureController@data')->name('units-measures.data');
Route::resource('config/units-measures', 'Admin\ConfigUnitMeasureController');

// Métodos de envio.
Route::post('config/shippings/loader', 'Admin\ConfigShippingController@load')->name('shippings.load');
Route::resource('config/shippings', 'Admin\ConfigShippingController');

// Perfil e porcentagens de preços do cliente.
Route::resource('config/customers-perfil', 'Admin\ConfigProfileClientController');
Route::post('config/customers-perfil/data', 'Admin\ConfigProfileClientController@data')->name('customers-perfil.data');

// Porcentagens sobre os produtos.
Route::post('config/percents/data', 'Admin\ConfigPercentController@data')->name('percents.data');
Route::resource('config/percents', 'Admin\ConfigPercentController');

//Calcular Cubagem
Route::get('config/calculate/cubage', 'Admin\ConfigCubage@calculate');
