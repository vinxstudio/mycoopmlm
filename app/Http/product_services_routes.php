<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/**
 * Program Services Routes
 */
Route::group(['prefix' => 'member/programServices', 'as' => 'memberProgramServices'], function () {
    Route::get('/', ['uses' => 'ProgramServicesController@index']);
    Route::get('{programServiceSlug}', [ 'uses' => 'ProgramServicesController@show']);
    Route::post('savings/store', [ 'uses' => 'SavingsController@store']);
    Route::post('damayan/store', [ 'uses' => 'DamayanController@store']);
    Route::post('financing/store', [ 'uses' => 'FinancingController@store']);
    Route::post('hospitalization/store', [ 'uses' => 'HospitalizationController@store']);
    Route::post('franchise/store', [ 'uses' => 'FranchiseController@store']);
    Route::post('etours/store', [ 'uses' => 'EToursController@store']);
    Route::post('eHotel/store', [ 'uses' => 'EHotelController@store']);
});

/**
 * (Program and Services) Transaction Routes
 */
Route::group(['prefix' => 'member/transactions'], function () {
    Route::get('/', ['uses' => 'TransactionsController@index']);
    Route::get('/{transaction}', ['uses' => 'TransactionsController@show']);
});

/**
 * (Products) Purchases Routes
 */
Route::group(['prefix' => 'member/purchases'], function () {
    Route::get('/list', ['uses' => 'PurchasesController@index']);
    Route::post('/store', ['uses' => 'PurchasesController@store']);
});

/**
 * Cart Routes
 *
 */
Route::group(['prefix' => 'member/cart'], function () {
	Route::get('/', ['uses' => 'EcommerceController@cart']);
    Route::post('/update/', ['uses' => 'EcommerceController@updateCart']);
	Route::get('/destroy', ['uses' => 'EcommerceController@destroy']);
	Route::get('/show', ['uses' => 'EcommerceController@viewCart']);
    Route::get('/placeOrder', ['uses' => 'EcommerceController@placeOrder']);
    Route::get('/purchaseOrder', ['uses' => 'EcommerceController@purchaseOrder']);
});

/**
 * Products Routes
 */
Route::group(['prefix' => 'member/products', 'as' => 'memberTransactions'], function () {
    Route::post('/addToCart/{productSlug}', ['uses' => 'EcommerceController@addToCart']);
    Route::post('/removeFromCart/{slug}', ['uses' => 'EcommerceController@removeFromCart']);
    Route::get('/{productSlug}', ['uses' => 'EcommerceController@show']);
});