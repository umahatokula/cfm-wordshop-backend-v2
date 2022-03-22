<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Api\PinController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\BundleController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\PreOrderController;
use App\Http\Controllers\Api\WishListController;
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

    // wallet pay
    Route::post('transactions/pay/wallet', [TransactionController::class, 'walletPay']);


});

    // cart
    Route::get('/cart',[CartController::class, 'index'])->name('cart.index');
    Route::post('/cart',[CartController::class, 'addToCart'])->name('cart.addToCart');
    Route::get('/cart/item/{rowId}',[CartController::class, 'getCartItem'])->name('cart.getCartItem');
    Route::get('/cart/update/{rowId}',[CartController::class, 'updateCartItem'])->name('cart.updateCart');
    Route::get('/cart/remove/{rowId}',[CartController::class, 'removeCartItem'])->name('cart.removeFromCart');
    Route::get('/cart/clear/',[CartController::class, 'clearCart'])->name('cart.clearCart');
    Route::get('/cart/summary/',[CartController::class, 'cartSummary'])->name('cart.cartSummary');


// categories
Route::get('categories', [CategoryController::class, 'index'])->name('api.categories.index');

// bundles
Route::get('bundles/search/{searchString}', [BundleController::class, 'searchBundles'])->name('api.bundles.search');
Route::get('bundles', [BundleController::class, 'index'])->name('api.bundles.index');
Route::get('bundles/{id}', [BundleController::class, 'show'])->name('api.bundles.details');

// orders
Route::get('orders/download/links/{transaction_number?}', [OrderController::class, 'downloadlinks'])->name('api.orders.downloadlinks');
Route::get('orders/download/{transaction_number?}', [OrderController::class, 'download'])->name('api.orders.download');
Route::get('orders/customer', [OrderController::class, 'myOrders'])->name('api.orders.index')->middleware('auth:sanctum');
Route::get('orders', [OrderController::class, 'index'])->name('api.orders.index');
Route::post('order', [OrderController::class, 'store'])->name('api.orders.store');
Route::get('orders/{order_number}', [OrderController::class, 'show'])->name('api.orders.show');

// products
Route::get('products/search/{searchString}', [ProductController::class, 'searchProducts'])->name('api.products.search');
Route::get('products/{id}/download', [ProductController::class, 'download'])->name('api.products.download');
Route::get('products', [ProductController::class, 'index'])->name('api.products.index');
Route::get('products/{id}', [ProductController::class, 'show'])->name('api.products.show');
Route::put('products/{id}/update/quantity/increase', [ProductController::class, 'increment'])->name('api.products.increase');
Route::put('products/{id}/update/quantity/decrease', [ProductController::class, 'decrement'])->name('api.products.decrease');

// pins
Route::get('pins/balance/{pin?}', [PinController::class, 'balance']);
Route::get('pins/isValid/{pin?}', [PinController::class, 'isValid']);

// transactions
Route::post('transactions/pay/pin', [TransactionController::class, 'pinPay'])->name('api.transactions.pinPay');
Route::post('transactions/pay/online', [TransactionController::class, 'onlinePay'])->name('api.transactions.onlinePay');

// customer
Route::put('/customer/{id}/update', [CustomerController::class, 'updateCustomerInfo'])->name('api.updateCustomerInfo');
Route::post('/pre-order', [PreOrderController::class, 'postOrder']);

// search
Route::get('/search/{query?}/{perPage?}', [SearchController::class, 'searcher'])->name('api.searcher');

// user
Route::post('signup', [UsersController::class, 'signup']);
Route::post('/login',[UsersController::class, 'login']);
