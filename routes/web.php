<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OutOfServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ConfirmController;
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

Route::get('/redirect', [AuthController::class, 'redirectToProvider'])->name('redirect');
Route::get('/callback', [AuthController::class, 'handleProviderCallback']);

Route::get('/register', [AuthController::class, 'register_view'])->name('register_view');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'login_view'])->name('login_view');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['authapi']], function () {

    Route::get('/', [HomeController::class, 'home_view'])->name('home');

    Route::get('/booking', [BookingController::class, 'booking_view'])->name('booking_view');
    Route::get('/booking/add/{id}', [BookingController::class, 'booking_add_view'])->name('booking_add_view');
    Route::post('/booking/add', [BookingController::class, 'booking_add'])->name('booking_add');

    Route::get('/order', [OrderController::class, 'order_view'])->name('order_view');
    Route::post('/order/confirm', [OrderController::class, 'order_confirm'])->name('order_confirm');
    Route::get('/order/add/item/{id}', [OrderController::class, 'order_add_view'])->name('order_add_view');
    Route::post('/order/view/booking/add/item', [OrderController::class, 'order_item_add_view'])->name('order_item_add_view');
    Route::post('/order/booking/add/item', [OrderController::class, 'order_item_add'])->name('order_item_add');
    Route::get('/order/view/item/{id}', [OrderController::class, 'order_item_view'])->name('order_item_view');
    Route::get('/order/view/edit/booking/{id}', [OrderController::class, 'order_edit_booking_view'])->name('order_edit_booking_view');
    Route::post('/order/view/edit/booking', [OrderController::class, 'order_edit_booking'])->name('order_edit_booking');
    Route::get('/order/view/edit/item', [OrderController::class, 'order_item_edit_view'])->name('order_item_edit_view');
    Route::post('/order/view/edit/item', [OrderController::class, 'order_item_edit'])->name('order_item_edit');
    Route::post('/order/view/delete/item', [OrderController::class, 'order_item_delete'])->name('order_item_delete');

    Route::get('/item', [ItemController::class, 'item_view'])->name('item_view');

    Route::group(['middleware' => ['isStaff']], function () {
        Route::get('/item/add', [ItemController::class, 'item_add_view'])->name('item_add_view');
        Route::post('/item/add', [ItemController::class, 'item_add'])->name('item_add');

        Route::get('/item/edit/{id}', [ItemController::class, 'item_edit_view'])->name('item_edit_view');
        Route::post('/item/edit', [ItemController::class, 'item_edit'])->name('item_edit');

        Route::get('/item/add/stock/{id}', [ItemController::class, 'item_add_stock_view'])->name('item_add_stock_view');
        Route::post('/item/add/stock', [ItemController::class, 'item_add_stock'])->name('item_add_stock');

        Route::get('/outOfService', [OutOfServiceController::class, 'outOfService_view'])->name('outOfService_view');
        Route::get('/outOfService/add/{id}', [OutOfServiceController::class, 'outOfService_add_view'])->name('outOfService_add_view');
        Route::post('/outOfService/add', [OutOfServiceController::class, 'outOfService_add'])->name('outOfService_add');
        Route::post('/outOfService/edit', [OutOfServiceController::class, 'outOfService_edit'])->name('outOfService_edit');

        Route::get('/confirm', [ConfirmController::class, 'confirm_view'])->name('confirm_view');
        Route::get('/confirm/view/item/{id}', [ConfirmController::class, 'confirm_view_item'])->name('confirm_view_item');
        Route::post('/confirm/status', [ConfirmController::class, 'confirm_status'])->name('confirm_status');
        Route::post('/confirm/reject', [ConfirmController::class, 'confirm_reject'])->name('confirm_reject');
        Route::post('/confirm/status/item', [ConfirmController::class, 'confirm_status_item'])->name('confirm_status_item');
        Route::post('/confirm/reject/item', [ConfirmController::class, 'confirm_reject_item'])->name('confirm_reject_item');

        Route::get('/history', [ConfirmController::class, 'history'])->name('history');
    });

    Route::group(['middleware' => ['isOwner']], function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard_view'])->name('dashboard');
        Route::post('/dashboard/add/staff', [DashboardController::class, 'dashboard_add_staff'])->name('dashboard_add_staff');
    });
});
