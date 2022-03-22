<?php

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PinController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\BundleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\PreacherController;
use App\Http\Controllers\PreOrderController;
use App\Http\Controllers\S3ObjectController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PreOrderTypesController;

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

Route::group(['middleware' => 'auth:sanctum', 'verified'], function() {
    
    Route::get('/', function () {
        return redirect('dashboard');
    });

    // dashboard
    Route::get('dashboard', [DashboardController::class, 'admin'])->name('dashboard');

    // users
    Route::get('users/{id}/delete', [UsersController::class. 'delete'])->name('users.delete');
    Route::resource('users', UsersController::class);

    // bundles
    Route::get('bundles/{id}/delete', [BundleController::class, 'delete'])->name('bundles.delete');
    Route::resource('bundles', BundleController::class);

    // order
    Route::get('orders/{id}/delete', [OrderController::class, 'delete'])->name('orders.delete');
    Route::get('orders/{id}/resend/links', [OrderController::class, 'resendLinks'])->name('orders.resendLinks');
    Route::resource('orders', OrderController::class);

    // pins
    Route::group(['middleware' => ['can:manage pins']], function () {
        Route::get('pins/listPins', [PinController::class, 'listPins'])->name('pins.listPins');
        Route::get('pins/create', [PinController::class, 'create'])->name('pins.create');
        Route::post('pins/generate', [PinController::class, 'generatePINs'])->name('pins.generate');
        Route::get('pins/{pin_id}/transactions', [PinController::class, 'transactions'])->name('pins.transactions');
    });

    // transactions
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');

    // order details
    Route::get('orders/{id}/details', [OrderDetailController::class, 'details'])->name('orders.details');

    // products
    // Route::get('products/{id}/temp_url', 'ProductController@tempUrl')->name('products.tempUrl');
    Route::get('products/{id}/download', [ProductController::class, 'download'])->name('products.download');
    Route::resource('products', ProductController::class);

    // s3Objects
    Route::resource('s3objects', S3ObjectController::class);

    // preachers
    Route::resource('preachers', PreacherController::class);

    // roles
    Route::get('roles', [RolesController::class, 'getRoles'])->name('roles');

    // home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // reports
    Route::get('reports', [ReportsController::class, 'index'])->name('reports.index');

    // preorder type
    Route::get('pre-order-type', [PreOrderTypesController::class, 'index'])->name('pre-order-type.index');
    Route::get('pre-order-type/create', [PreOrderTypesController::class, 'create'])->name('pre-order-type.create');
    Route::post('pre-order-type/store', [PreOrderTypesController::class, 'store'])->name('pre-order-type.store');
    Route::get('pre-order-type/{preOrderType}/send-links', [PreOrderTypesController::class, 'sendLinks'])->name('pre-order-type.send-links');

    // preorder 
    Route::get('pre-orders/orders', [PreOrderController::class, 'listOrders'])->name('pre-orders.list-order');
    Route::get('pre-orders/{preOrderType}/details', [PreOrderController::class, 'details'])->name('pre-orders.details');

});



Route::get('/test', function () {
    $data['order'] = App\Order::where('order_number', 'B77RGQHRB1')->first();

    return view('mails.orders.paid', $data);
});
