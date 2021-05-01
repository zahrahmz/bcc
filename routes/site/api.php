<?php
//Added by nima

use App\Http\Controllers\Site\AddressController;
use App\Http\Controllers\Site\CartController;
use App\Http\Controllers\Site\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('get-city-of-province/{province}', [AddressController::class,'getCitiesOfProvince']);
Route::get('get-price-product-by-product-attribute/{productAttribute}', [ProductController::class,'getProductPriceByProductAttribute']);
Route::post('cart/{cart}/cartItem/{cartItem}/change-quantity', [CartController::class, 'changeQuantityOfCartProduct'])->middleware('auth.basic')->name('cart.change');
