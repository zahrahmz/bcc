<?php


use App\Http\Controllers\Admin\AddressController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValuesController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UserController;
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
Route::get('login', 'Admin\LoginController@showLoginForm')->name('login');
Route::post('login', 'Admin\LoginController@login')->name('login.store');
Route::get('logout', 'Admin\LoginController@logout')->name('logout');
Route::group(['middleware' => ['auth:admin']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::group(['prefix' => 'orders'], function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders.index');
    });
    /**
     * Products Routes
     */
    Route::group(['prefix' => 'products'], function () {
        Route::get('/', [ProductController::class, 'index'])->name('products.index');
        Route::get('/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/store', [ProductController::class, 'store'])->name('products.store');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::patch('/{product}/update', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/{product}/delete', [ProductController::class, 'delete'])->name('products.delete');
        Route::get('/{product}/assignAttributes', [ProductController::class, 'assignAttributes'])->name('products.assignAttributes');
        Route::post('/{product}/storeAssignAttributes', [ProductController::class, 'storeAssignAttributes'])->name('products.storeAssignAttributes');
        Route::patch('/{product}/attribute/{attribute}/updateProductPriceAttribute', [ProductController::class, 'updateProductPriceAttribute'])->name('products.updateProductPriceAttribute');
        Route::patch('/{product}/attribute/{attribute}/updateProductQuantityAttribute', [ProductController::class, 'updateProductQuantityAttribute'])->name('products.updateProductQuantityAttribute');
        Route::post('/{product}/upload-images', [ProductController::class, 'uploadImages'])->name('product.upload_images');
        Route::delete('/{product}/image/{image}/delete', [ProductController::class, 'deleteImage'])->name('product.delete_upload_images');
    });
    /**
     * Attribute Routes
     */
    Route::group(['prefix' => 'attributes'], function () {
        Route::get('/', [AttributeController::class, 'index'])->name('attributes.index');
        Route::get('/create', [AttributeController::class, 'create'])->name('attributes.create');
        Route::post('/store', [AttributeController::class, 'store'])->name('attributes.store');
        Route::get('/{attribute}/edit', [AttributeController::class, 'edit'])->name('attributes.edit');
        Route::patch('/{attribute}/update', [AttributeController::class, 'update'])->name('attributes.update');
        Route::delete('/{attribute}/delete', [AttributeController::class, 'delete'])->name('attributes.delete');
    });
    /**
     * Attribute Values Routes
     */
    Route::group(['prefix' => 'attributes/{attribute}'], function () {
        Route::group(['prefix' => 'values'], function () {
            Route::get('/create', [AttributeValuesController::class, 'create'])->name('attributevalues.create');
            Route::post('/store', [AttributeValuesController::class, 'store'])->name('attributevalues.store');
            Route::get('/{value}/edit', [AttributeValuesController::class, 'edit'])->name('attributevalues.edit');
            Route::patch('/{value}/update', [AttributeValuesController::class, 'update'])->name('attributevalues.update');
            Route::delete('/{value}/delete', [AttributeValuesController::class, 'delete'])->name('attributevalues.delete');
        });
    });
    /**
     * Admin Users Routes
     */
    Route::group(['prefix' => 'admins'], function () {
        Route::get('', [AdminController::class, 'index'])->name('admins.index');
        Route::get('create', [AdminController::class, 'create'])->name('admins.create');
        Route::post('store', [AdminController::class, 'store'])->name('admins.store');
        Route::get('{admin}/edit', [AdminController::class, 'edit'])->name('admins.edit');
        Route::patch('{admin}/update', [AdminController::class, 'update'])->name('admins.update');
        Route::delete('{admin}/delete', [AdminController::class, 'delete'])->name('admins.delete');
        Route::get('loginAs/{user}', [AdminController::class, 'loginAS'])->name('admins.loginAs');
    });


    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::patch('/{user}/update', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{user}/delete', [UserController::class, 'delete'])->name('users.delete');
        Route::get('/{user}/address/create', [AddressController::class, 'create'])->name('addresses.create');
        Route::post('/{user}/address/store', [AddressController::class, 'store'])->name('addresses.store');
    });

    /**
     * Categories Routes
     */
    Route::group(['prefix','categories'], function () {
        Route::delete('/categories/{category}/image/{image}/delete', [CategoryController::class, 'deleteImage'])->name('category.delete_upload_images');
        Route::resource('categories', 'Admin\CategoryController')->except(['destroy']);
        Route::post('/{category}/upload-images', [CategoryController::class, 'uploadImages'])->name('category.upload_images');
        Route::delete('{category}', [CategoryController::class, 'delete'])->name('categories.delete');
        Route::get('/categories/add-photo/{category}/', [CategoryController::class, 'addPhoto'])->name('categories.add-photo');
    });

    /**
     * Shipments Routes
     */
    Route::group(['prefix' => 'shipments'], function () {
        Route::resource('shipments', 'Admin\ShipmentController');
    });

    /**
     * Settings Routes
     */
    Route::group(['prefix' => 'settings'], function () {
        Route::resource('settings', 'Admin\SettingController');
    });

    /**
     * Settings Routes
     */
    Route::group(['prefix' => 'sliders'], function () {
        Route::get('', [SliderController::class, 'index'])->name('sliders.index');
        Route::get('create', [SliderController::class, 'create'])->name('sliders.create');
        Route::post('store', [SliderController::class, 'store'])->name('sliders.store');
        Route::get('{slider}/edit', [SliderController::class, 'edit'])->name('sliders.edit');
        Route::patch('{slider}/update', [SliderController::class, 'update'])->name('sliders.update');
        Route::delete('{slider}/delete', [SliderController::class, 'delete'])->name('sliders.delete');
        Route::post('{slider}/upload-image', [SliderController::class, 'uploadImages'])->name('sliders.upload_image');
        Route::delete('{slider}/image/{image}/delete', [SliderController::class, 'deleteImage'])->name('sliders.delete_upload_images');
        Route::get('add-photo/{slider}', [SliderController::class, 'addPhoto'])->name('sliders.add-photo');
    });


    Route::group(['prefix' => 'discount'], function () {
        Route::get('/', [DiscountController::class, 'index'])->name('discount.index');
        Route::get('/create', [DiscountController::class, 'create'])->name('discount.create');
        Route::post('/store', [DiscountController::class, 'store'])->name('discount.store');
        Route::delete('/{discount}/delete', [DiscountController::class, 'delete'])->name('discount.delete');
    });
});
