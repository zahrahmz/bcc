<?php

use App\Http\Controllers\Site\AddressController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\CartController;
use App\Http\Controllers\Site\OrderController;
use App\Http\Controllers\Site\PaymentController;
use App\Http\Controllers\Site\ProductController;
use App\Http\Controllers\Site\WishListController;
use Illuminate\Support\Facades\Route;

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

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('site.login');
Route::post('login', 'Auth\LoginController@login')->name('site.login.store');
Route::get('logout', 'Auth\LoginController@logout')->name('site.logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('site.register');
Route::post('register', 'Auth\RegisterController@register')->name('site.register.store');
Route::get('verify/{mobile}', 'Auth\RegisterController@showVerificationForm')->name('site.verify');
Route::post('verify', 'Auth\RegisterController@verify')->name('site.verify.store');
Route::get('/resend/{mobile}', 'Auth\RegisterController@resendSms')->name('site.verify.resend.sms');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLink')->name('password.email');
Route::get('password/reset/sent-successfully', 'Auth\ForgotPasswordController@sentSuccessfully')->name('password.reset.sentSuccessfully');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset.store');


Route::group(['as' => 'site.'], function () {
    Route::get('/', [HomeController::class,'index'])->name('home.index');
    Route::get('/product/{product}', [ProductController::class,'show'])->name('product.show');
    Route::get('/product', [ProductController::class,'index'])->name('product.index');
    Route::post('/product/{product}/add-to-cart', [CartController::class,'addToCart'])->name('cart.add');
    Route::any('payment/callback', [PaymentController::class, 'callbackUrl'])->name('payment.callbackUrl');
});


Route::group(['middleware' => ['auth:site'],'as' => 'site.'], function () {
    Route::post('/product/{product}/add-to-wish-list', [WishListController::class,'store'])->name('product.add_to_wish_list');
    Route::group(['prefix' => 'cart'], function () {
        Route::get('show', [CartController::class,'show'])->name('cart.show');
        Route::group(['prefix' => '{cart}'], function () {
            Route::group(['prefix' => 'cartItem'], function () {
                Route::delete('{cartItem}/delete', [CartController::class,'removeCartItem'])->name('cart.delete');
            });
        });
    });


    Route::get('address/create', [AddressController::class, 'create'])->name('addresses.create');
    Route::post('address/store', [AddressController::class, 'store'])->name('addresses.store');
    Route::post('address', [AddressController::class, 'index'])->name('addresses.index');


    Route::post('order/store', [OrderController::class, 'createOrderAndGoToGateway'])->name('order.store');
});


Route::get('tt', [\App\Http\Controllers\ZahraController::class,'index']);//dont remove it,its for Zahra
