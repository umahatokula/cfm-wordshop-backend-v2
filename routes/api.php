<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PinController;
use App\Http\Controllers\Api\PreOrderController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\BundleController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\TransactionController;

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

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('/user/{id}', [UsersController::class, 'show']);
    Route::get('orders', [OrderController::class, 'myOrders']);
    Route::get('profile', [UsersController::class, 'profile']);
    Route::post('logout', [UsersController::class, 'logout']);

    // wallet
    Route::get('wallet/transactions', [WalletController::class, 'walletTransactions'])->name('api.wallet.all');
    Route::post('wallet/create', [WalletController::class, 'create'])->name('api.wallet.create');
    Route::get('wallet/debit/{id}', [WalletController::class, 'debit'])->name('api.wallet.debit');
    Route::get('wallet/credit/{id}', [WalletController::class, 'credit'])->name('api.wallet.credit');
    Route::get('wallet/balance/{id}', [WalletController::class, 'balance'])->name('api.wallet.balance');
    Route::post('wallet/fund', [WalletController::class, 'fund']);

});



// categories
Route::get('categories', [CategoryController::class, 'index'])->name('api.categories.index');

// bundles
Route::get('bundles/search/{searchString}', [BundleController::class, 'searchBundles'])->name('api.bundles.search');
Route::get('bundles/{id}/delete', [BundleController::class, 'delete'])->name('api.bundles.delete');
Route::get('bundles', [BundleController::class, 'index'])->name('api.bundles.index');
Route::get('bundles/details/{slug}', [BundleController::class, 'details'])->name('api.bundles.details');
Route::post('bundles/store', [BundleController::class, 'store'])->name('api.bundles.store');
Route::put('bundles/{id}/update', [BundleController::class, 'update'])->name('api.bundles.update');

// orders
Route::get('orders/download/links/{transaction_number?}', [OrderController::class, 'downloadlinks'])->name('api.orders.downloadlinks');
Route::get('orders/download/{transaction_number?}', [OrderController::class, 'download'])->name('api.orders.download');
Route::get('orders/{customer_id?}', [OrderController::class, 'index'])->name('api.orders.index');
Route::post('orders', [OrderController::class, 'store'])->name('api.orders.store');
Route::get('orders/{order_number}/details', [OrderController::class, 'show'])->name('api.orders.show');

// products
Route::get('products/search/{searchString}', [ProductController::class, 'searchProducts'])->name('api.products.search');
Route::get('products/{id}/download', [ProductController::class, 'download'])->name('api.products.download');
Route::get('products/{category_slug?}', [ProductController::class, 'index'])->name('api.products.index');
Route::get('products/entire', [ProductController::class, 'entire'])->name('api.products.entire');
Route::get('products/{id}', [ProductController::class, 'show'])->name('api.products.show');
Route::get('products/details/{slug}', [ProductController::class, 'details'])->name('api.products.details');
Route::put('products/{id}/update/quantity/increase', [ProductController::class, 'increment'])->name('api.products.increase');
Route::put('products/{id}/update/quantity/decrease', [ProductController::class, 'decrement'])->name('api.products.decrease');

// pins
Route::get('pins/{pin}/check', [PinController::class, 'check'])->name('api.pins.check');

// transactions
Route::post('transactions/pay/pin', [TransactionController::class, 'pinPay'])->name('api.transactions.pinPay');
Route::post('transactions/pay/online', [TransactionController::class, 'onlinePay'])->name('api.transactions.onlinePay');

// customer
Route::put('/customer/{id}/update', [CustomerController::class, 'updateCustomerInfo'])->name('api.updateCustomerInfo');
Route::post('/pre-order', [PreOrderController::class, 'postOrder']);

// user
Route::post('signup', [UsersController::class, 'signup']);
Route::post('/login',[UsersController::class, 'login']);
