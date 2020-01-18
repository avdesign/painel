<?php
/**
 * Anselmo Velame.
 * User: avdesign
 * Date: 09/10/19
 * Time: 11:30
 */

Route::get('gateway/pagseguro/{id}', 'Gateway\PagSeguroController@index');
Route::get('gateway/pagseguro/{id}/cancel', 'Gateway\PagSeguroController@cancel');
Route::put('gateway/pagseguro/cancel-transaction', 'Gateway\PagSeguroController@cancelTransaction')->name('pagseguro-cancel');
Route::put('gateway/pagseguro/reverse-transaction', 'Gateway\PagSeguroController@ReverseTransaction')->name('pagseguro-reverse');

Route::get('generate-billet/{reference}', 'Gateway\PaymentBilletController@generateBillet')->name('generate.billet');

