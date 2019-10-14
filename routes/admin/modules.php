<?php

/*
|--------------------------------------------------------------------------
| Autenticação de UsuáriosADMIN
|--------------------------------------------------------------------------
*/

Route::post('perfil-cliente/prices', 'Admin\ConfigProfileClientController@prices')->name('profile.client.get.prices');
Route::post('perfil-cliente/offers', 'Admin\ConfigProfileClientController@offers')->name('profile.client.get.offers');









// Conteudo do site
// Contrato de Compra Venda
Route::resource('content/contract', 'Admin\ContentContractController', ['except' => ['edit']]);
Route::get('content/contract-load', 'Admin\ContentContractController@loadContent')->name('contract.load');
Route::get('content/contract-order/{id}', 'Admin\ContentContractController@order')->name('contract.order');
Route::put('content/contract-order/{id}', 'Admin\ContentContractController@updateOrder')->name('contract.order');
Route::put('content/contract-status/{id}', 'Admin\ContentContractController@status')->name('contract.status');
// Política e Privacidade
Route::resource('content/privacy-policy', 'Admin\ContentPrivacyPolicyController', ['except' => ['edit']]);
Route::get('content/privacy-policy-load', 'Admin\ContentPrivacyPolicyController@loadContent')->name('privacy-policy.load');
Route::get('content/privacy-policy-order/{id}', 'Admin\ContentPrivacyPolicyController@order')->name('privacy-policy.order');
Route::put('content/privacy-policy-order/{id}', 'Admin\ContentPrivacyPolicyController@updateOrder')->name('privacy-policy.order');
Route::put('content/privacy-policy-status/{id}', 'Admin\ContentPrivacyPolicyController@status')->name('privacy-policy.status');
// Termos e Condições
Route::resource('content/terms-conditions', 'Admin\ContentTermsConditionsController', ['except' => ['edit']]);
Route::get('content/terms-conditions-load', 'Admin\ContentTermsConditionsController@loadContent')->name('terms-conditions.load');
Route::get('content/terms-conditions-order/{id}', 'Admin\ContentTermsConditionsController@order')->name('terms-conditions.order');
Route::put('content/terms-conditions-order/{id}', 'Admin\ContentTermsConditionsController@updateOrder')->name('terms-conditions.order');
Route::put('content/terms-conditions-status/{id}', 'Admin\ContentTermsConditionsController@status')->name('terms-conditions.status');
//Forma de Pagamento
Route::resource('content/form-payment', 'Admin\ContentFormPaymentController', ['except' => ['edit']]);
Route::get('content/form-payment-load', 'Admin\ContentFormPaymentController@loadContent')->name('form-payment.load');
Route::get('content/form-payment-order/{id}', 'Admin\ContentFormPaymentController@order')->name('form-payment.order');
Route::put('content/form-payment-order/{id}', 'Admin\ContentFormPaymentController@updateOrder')->name('form-payment.order');
Route::put('content/form-payment-status/{id}', 'Admin\ContentFormPaymentController@status')->name('form-payment.status');
// Entrega de Devolução
Route::resource('content/delivery-return', 'Admin\ContentDeliveryReturnController', ['except' => ['edit']]);
Route::get('content/delivery-return-load', 'Admin\ContentDeliveryReturnController@loadContent')->name('delivery-return.load');
Route::get('content/delivery-return-order/{id}', 'Admin\ContentDeliveryReturnController@order')->name('delivery-return.order');
Route::put('content/delivery-return-order/{id}', 'Admin\ContentDeliveryReturnController@updateOrder')->name('delivery-return.order');
Route::put('content/delivery-return-status/{id}', 'Admin\ContentDeliveryReturnController@status')->name('delivery-return.status');
// Política de Entrega
Route::resource('content/delivery', 'Admin\ContentDeliveryController', ['except' => ['edit']]);
Route::get('content/delivery-load', 'Admin\ContentDeliveryController@loadContent')->name('delivery.load');
Route::get('content/delivery-order/{id}', 'Admin\ContentDeliveryController@order')->name('delivery.order');
Route::put('content/delivery-order/{id}', 'Admin\ContentDeliveryController@updateOrder')->name('delivery.order');
Route::put('content/delivery-status/{id}', 'Admin\ContentDeliveryController@status')->name('delivery-return.status');
// Perguntas Frequentes
Route::resource('content/faqs', 'Admin\ContentFaqController', ['except' => ['edit']]);
Route::get('content/faqs-load', 'Admin\ContentFaqController@loadContent')->name('faqs.load');
Route::get('content/faqs-order/{id}', 'Admin\ContentFaqController@order')->name('faqs.order');
Route::put('content/faqs-order/{id}', 'Admin\ContentFaqController@updateOrder')->name('faqs.order');
Route::put('content/faqs-status/{id}', 'Admin\ContentFaqController@status')->name('faqs.status');




// Slider Home
Route::resource('images/{id}/banner-slider', 'Admin\ImageSliderController');
Route::put('images/{id}/slider/status', 'Admin\ImageSliderController@status')->name('banner-slider.status');
Route::get('images/{id}/slider/order', 'Admin\ImageSliderController@order')->name('banner-slider.order');
Route::put('images/slider/order', 'Admin\ImageSliderController@updateOrder')->name('banner-slider.order');

// Banner Home
Route::resource('images/{id}/banner', 'Admin\ImageBannerController', ['except' => ['show']]);
Route::put('images/banner/status/{id}', 'Admin\ImageBannerController@status')->name('banner.status');
Route::get('images/banner/order/{id}', 'Admin\ImageBannerController@order')->name('banner.order');
Route::put('images/banner/order', 'Admin\ImageBannerController@updateOrder')->name('banner.order');


// Lista de Desejos
Route::resource('wishlist', 'Admin\WishlistController');
Route::post('wishlist/data', 'Admin\WishlistController@data')->name('wishlist.data');
Route::get('wishlist/{id}/profile', 'Admin\WishlistController@profile')->name('wishlist.profile');
Route::get('wishlist/{id}/lists', 'Admin\WishlistController@lists')->name('wishlist.lists');
Route::get('wishlist/{id}/reload', 'Admin\WishlistController@reload')->name('wishlist.reload');
Route::get('wishlist/{id}/products', 'Admin\WishlistController@products')->name('wishlist.products');
Route::post('wishlist/{id}/add/{user_id}', 'Admin\WishlistController@add')->name('wishlist.add');
Route::post('wishlist/{user_id}/search', 'Admin\WishlistController@search')->name('wishlist.search');
Route::delete('wishlist/delete/{user_id}/all', 'Admin\WishlistController@deleteAll')->name('wishlist.delete.all');
Route::get('wishlist/admin/{user_id}/edit', 'Admin\WishlistController@editAdmin')->name('wishlist.admin.edit');
Route::put('wishlist/admin/{user_id}/store', 'Admin\WishlistController@storeAdmin')->name('wishlist.admin.store');
Route::get('wishlist/admin/{user_id}/save', 'Admin\WishlistController@saveWishlist')->name('wishlist.save');

// Pedidos
Route::resource('orders', 'Admin\OrderController');
Route::post('orders/data', 'Admin\OrderController@data')->name('orders.data');
Route::get('order/{id}/details', 'Admin\OrderController@details');
Route::resource('order/{id}/order-items', 'Admin\OrderItemController',['except' => ['store','show']]);
Route::get('order/{id}/products', 'Admin\OrderItemController@products')->name('order-items.products');
Route::post('order/{id}/search', 'Admin\OrderItemController@search')->name('order-items.search');
Route::post('order/{id}/add/{order_id}', 'Admin\OrderItemController@add')->name('order-items.add');
Route::get('order/{id}/reload', 'Admin\OrderItemController@reload')->name('order-items.reload');
Route::resource('order/{id}/order-notes', 'Admin\OrderNoteController');
Route::resource('order/{id}/order-shippings', 'Admin\OrderShippingController');
// Pedidos Excluded
Route::post('orders/excluded/data', 'Admin\OrderController@dataExcluded')->name('orders.excluded.data');
Route::post('order/{id}/reactivate', 'Admin\OrderController@reactivate');
// Imprimir PDF
Route::get('order/{id}/printer', 'Admin\OrderController@printerPdf')->name('order-items.printer');
Route::get('order/{id}/download', 'Admin\OrderController@downloadPdf')->name('order-items.download');

// Clientes
Route::resource('accounts', 'Admin\UserController');
Route::post('accounts/data', 'Admin\UserController@data')->name('accounts.data');
Route::get('account/{id}/profile', 'Admin\UserController@profile')->name('account.profile');
Route::get('account/load/profile/{opc}/update/{id}', 'Admin\UserController@loadUpdateProfile');
Route::get('account/load/profile/{opc}', 'Admin\UserController@loadProfile');
// Endereços
Route::resource('account/{id}/address', 'Admin\UserAddressController');
Route::get('address/{id}/refresh', 'Admin\UserAddressController@refresh')->name('account-address.refresh');
// Observações
Route::resource('account/{id}/notes', 'Admin\UserNoteController');
Route::get('note/{id}/refresh', 'Admin\UserNoteController@refresh')->name('account-notes.refresh');
// Excluidos
Route::get('accounts/excluded', 'Admin\UserController@show')->name('accounts.excluded');
Route::post('accounts/excluded/data', 'Admin\UserController@dataExcluded')->name('accounts.excluded.data');
Route::post('account/{id}/reactivate', 'Admin\UserController@reactivate');

// Contato
Route::resource('contacts', 'Admin\ContactController');
Route::get('contacts/message/{id}', 'Admin\ContactController@message')->name('contacts.message');
Route::get('contacts/{id}/details', 'Admin\ContactController@details')->name('contacts.details');
Route::post('contacts/data', 'Admin\ContactController@data')->name('contacts.data');
Route::post('contacts/{id}/response', 'Admin\ContactController@response')->name('contacts.response');
Route::post('contacts/{id}/status', 'Admin\ContactController@status')->name('contacts.status');
Route::post('contacts/{id}/spam', 'Admin\ContactController@spam')->name('contacts.spam');
Route::get('contacts/{id}/refresh', 'Admin\ContactController@refresh')->name('contacts.refresh');

// Spams Contatos
Route::resource('spams', 'Admin\ContactSpamController');
Route::post('spams/data', 'Admin\ContactSpamController@data')->name('spams.data');
Route::get('spam/message/{id}', 'Admin\ContactSpamController@message')->name('spams.message');
Route::get('spam/{id}/details', 'Admin\ContactSpamController@details')->name('spams.details');


// Seções dos Produtos
Route::resource('sections', 'Admin\SectionController');
Route::post('sections/data', 'Admin\SectionController@data')->name('sections.data');
Route::get('section/{id}/details', 'Admin\SectionController@details')->name('section.details');
Route::resource('section/{id}/grids-section', 'Admin\GridSectionController');
Route::get('section/{id}/grids-load', 'Admin\GridSectionController@load')->name('section-grids-load');
Route::resource('section/{id}/featured-section', 'Admin\FeaturedSectionController');
Route::put('section/status/{id}/featured', 'Admin\FeaturedSectionController@status')->name('featured-section.status');
Route::resource('section/{id}/banner-section', 'Admin\BannerSectionController');
Route::put('section/status/{id}/banner', 'Admin\BannerSectionController@status')->name('banner-section.status');

// Categorias dos Produtos
Route::resource('categories', 'Admin\CategoryController');
Route::post('categories/data', 'Admin\CategoryController@data')->name('categories.data');
Route::get('category/{id}/details', 'Admin\CategoryController@details')->name('category.details');
Route::resource('category/{id}/grids-category', 'Admin\GridCategoryController');
Route::get('category/{id}/grids-load', 'Admin\GridCategoryController@load')->name('category-grids-load');
Route::resource('category/{id}/featured-category', 'Admin\FeaturedCategoryController');
Route::put('category/status/{id}/featured', 'Admin\FeaturedCategoryController@status')->name('featured-category.status');
Route::resource('category/{id}/banner-category', 'Admin\BannerCategoryController');
Route::put('category/status/{id}/banner', 'Admin\BannerCategoryController@status')->name('banner-category.status');


// Marcas & Fabricantes
Route::resource('brands', 'Admin\BrandController');
Route::post('brands/data', 'Admin\BrandController@data')->name('brands.data');
Route::get('brand/{id}/details', 'Admin\BrandController@details')->name('brands.details');
Route::resource('brand/{id}/grids-brand', 'Admin\GridBrandController');
Route::get('brand/{id}/grids-load', 'Admin\GridBrandController@load')->name('brand-grids-load');
Route::resource('brand/{id}/logo-brand', 'Admin\LogoBrandController');
Route::put('brand/status/{id}/logo', 'Admin\LogoBrandController@status')->name('logo-brand.status');
Route::resource('brand/{id}/banner-brand', 'Admin\BannerBrandController');
Route::put('brand/status/{id}/banner', 'Admin\BannerBrandController@status')->name('banner-brand.status');


// Products / Categories
Route::resource('products/{slug}/catalog', 'Admin\ProductController',['except' => ['show']]);
Route::post('products/{id}/data', 'Admin\ProductController@data')->name('products.data');
Route::put('product/{id}/status', 'Admin\ProductController@status')->name('product.status');
Route::get('product/{id}/details', 'Admin\ProductController@details');
Route::post('product/change/categories', 'Admin\ProductController@change')->name('change.product');

// Images Colors Products
Route::resource('colors/{idpro}/colors-product', 'Admin\ImageColorController',['except' => ['show']]);
Route::put('colors/{idpro}/status-color/{id}', 'Admin\ImageColorController@status')->name('status-color');

// Images Positions Colors
Route::resource('position/{idpro}/positions-product', 'Admin\ImagePositionController',['except' => ['show']]);
Route::put('position/{idpro}/status-position', 'Admin\ImagePositionController@status')->name('status-position');


// Cotroller das Grades
Route::resource('grids/grid-color', 'Admin\GridProductController',['except' => ['index', 'create']]);
Route::get('grids/change-grids', 'Admin\GridProductController@change')->name('change-grids');
Route::get('grids/load-grids', 'Admin\GridProductController@load')->name('load-grids');

// Catalogo das Cores
Route::get('catalog', 'Admin\CatalogController@index');
Route::post('catalog/data', 'Admin\CatalogController@data')->name('catalog.data');
Route::put('catalog/status/{id}', 'Admin\CatalogController@status')->name('status.catalog');

// Controle de Estoque
Route::get('inventory', 'Admin\InventoryController@index');
Route::post('inventory/data', 'Admin\InventoryController@data')->name('inventory.data');
Route::get('inventory/{id}/details', 'Admin\InventoryController@details');
Route::get('inventory/modal/{id}/admin', 'Admin\InventoryController@admin')->name('inventory.admin');
Route::get('inventory/modal/{id}/user', 'Admin\InventoryController@user')->name('inventory.user');
