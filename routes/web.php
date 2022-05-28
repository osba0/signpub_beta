<?php

use Illuminate\Support\Facades\Route;

use App\Models\UserRole;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\StatistiquesController;

use App\Http\Controllers\ChangePasswordController;

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
        
        Route::get('admin/clients', [ClientController::class, 'index'])->name('index.client');
        Route::get('clients/client-list', [ClientController::class, 'getListClient'])->name('client.list');

        Route::get('admin/orders/{id}/edit', [OrderController::class, 'editAdmin'])->name('admin.order.edit');

        Route::get('admin/config', [ConfigurationController::class, 'index'])->name('config.index');

        Route::get('config/matiere-list', [ConfigurationController::class, 'getListMatiere'])->name('matiere.list'); 

        Route::post('admin/config/update-other', [ConfigurationController::class, 'updateOther']);
        Route::post('admin/config/store-matiere', [ConfigurationController::class, 'store']);
        Route::post('admin/config/status-matiere', [ConfigurationController::class, 'updateStatusMatiere']); 
        Route::delete('admin/config/delete-matiere/{id}', [ConfigurationController::class, 'deleteMatiere']); 


        Route::get('admin/statistique', [StatistiquesController::class, 'index'])->name('statistique.index');


        Route::post('admin/statistique/search', [StatistiquesController::class, 'getSurfaceTireur']); 
    });

    Route::middleware(['role:' . UserRole::ROLE_SECRETARIAT])->group(function () {
        Route::get('admin/orders/{id}/edit', [OrderController::class, 'editAdmin'])->name('admin.order.edit');
    });

    Route::get('admin/client-infos/{id}', [UserController::class, 'getInfoClient']);

    Route::get('admin/order-list', [OrderController::class, 'getOrders'])->name('orders');
    Route::put('admin/change-status/{id}/{status}/{idUser}', [OrderController::class, 'update'])->name('change.status');

    Route::get('/order-get/{order}', [OrderController::class, 'orderShow'])->name('orders-show');

});

Route::middleware(['auth'])->group(function () {
   Route::get('orders/order-list', [OrderController::class, 'index'])->name('order.list');
   Route::get('orders/create', [OrderController::class, 'create'])->name('order.create');
   Route::get('orders/{id}/edit', [OrderController::class, 'edit'])->name('order.edit');
   Route::put('orders/update', [OrderController::class, 'updateOrder'])->name('order.update');
   Route::post('orders/order-store', [OrderController::class, 'store'])->name('order.store');
   Route::get('orders/{order}', [OrderController::class, 'orderView'])->name('orders-view');
   Route::delete('order/delete/{id}', [OrderController::class, 'deleteOrder']); 

   Route::get('user/profil', [UserController::class, 'getProfil'])->name('user.profil');
   Route::put('user/update', [UserController::class, 'UpdateUserSimple'])->name('user.update');
   
   Route::get('user/client-infos/{id}', [UserController::class, 'getInfoClient']);
});


Route::get('change-password', [ChangePasswordController::class, 'index']);
Route::post('change-password', [ChangePasswordController::class, 'store'])->name('change.password');

