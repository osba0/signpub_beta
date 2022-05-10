<?php

use Illuminate\Support\Facades\Route;

use App\Models\UserRole;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;

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

/*Route::get('/', function () {
    return view('welcome');
});*/


Auth::routes(['verify' => true]);

Route::get('/',  [HomeController::class, 'index'])->name('home');
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('admin/home', [HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');

Route::get('admin/users', [UserController::class, 'index'])->name('admin.user')->middleware('is_admin');

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::middleware(['role:' . UserRole::ROLE_ADMIN])->group(function () {
        Route::get('users/user-list', [UserController::class, 'getListUser'])->name('user.list');
        Route::get('users/user-create', [UserController::class, 'create'])->name('user.create');
        Route::post('users/user-store', [UserController::class, 'store'])->name('user.store');

        Route::get('admin/orders/{id}/edit', [OrderController::class, 'editAdmin'])->name('admin.order.edit');
    });

    Route::middleware(['role:' . UserRole::ROLE_SECRETARIAT])->group(function () {
        Route::get('admin/orders/{id}/edit', [OrderController::class, 'editAdmin'])->name('admin.order.edit');
    });

    Route::get('admin/order-list', [OrderController::class, 'getOrders'])->name('orders');
    Route::put('admin/change-status/{id}/{status}', [OrderController::class, 'update'])->name('change.status');
});

Route::middleware(['auth'])->group(function () {
   Route::get('orders/order-list', [OrderController::class, 'index'])->name('order.list');
   Route::get('orders/create', [OrderController::class, 'create'])->name('order.create');
   Route::get('orders/{id}/edit', [OrderController::class, 'edit'])->name('order.edit');
   Route::put('orders/update', [OrderController::class, 'updateOrder'])->name('order.update');
   Route::post('orders/order-store', [OrderController::class, 'store'])->name('order.store');
});

