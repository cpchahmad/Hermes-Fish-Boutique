<?php

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

//Route::get('/', function () {
//    return view('welcome');
//});


Route::group(['middleware'=>['verify.shopify']], function () {

    //Orders
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'orders'])->name('home');
    Route::get('sync-orders', [\App\Http\Controllers\AdminController::class, 'ShopifyOrders'])->name('sync.orders');
    Route::get('order-view/{id}', [\App\Http\Controllers\AdminController::class, 'order_view'])->name('order.view');
    Route::get('filter-orders', [\App\Http\Controllers\AdminController::class, 'filter_orders'])->name('filter.orders');

    // products
    Route::get('sync-products', [\App\Http\Controllers\AdminController::class, 'ShopifyProducts'])->name('sync.products');

    //Checkout Orders
    Route::get('checkout-orders', [\App\Http\Controllers\AdminController::class, 'checkout_orders'])->name('checkout.orders');
    Route::get('check-order-view/{id}', [\App\Http\Controllers\AdminController::class, 'check_order_view'])->name('check.order.view');

    //draft order
    Route::get('draft-orders', [\App\Http\Controllers\AdminController::class, 'draft_orders'])->name('draft.orders');

    Route::post('create-order', [\App\Http\Controllers\AdminController::class, 'create_order'])->name('create.order');

    //shiping day
    Route::get('shipping-day', [\App\Http\Controllers\AdminController::class, 'shipping_day'])->name('shipping_day');
    Route::post('add-shipping-day', [\App\Http\Controllers\AdminController::class, 'add_shipping_day'])->name('shipping_day.add');
    Route::post('update-shipping_day/{id}', [\App\Http\Controllers\AdminController::class, 'update_shipping_day'])->name('shipping_day.update');
    Route::get('delete-shipping_day/{id}', [\App\Http\Controllers\AdminController::class, 'delete_shipping_day'])->name('shipping_day.delete');

});
    Route::post('checkout-data', [\App\Http\Controllers\AdminController::class, 'checkout_data'])->name('checkout-data');
