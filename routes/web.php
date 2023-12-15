<?php

use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\TemplateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductoController;

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

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login-store');
});

Route::middleware('auth')->group(function () {
    Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('stock', [ProductoController::class, 'index'])->name('stock');
    Route::get('order-status/{status?}', [OrderController::class, 'index'])->name('order-status');

    Route::get('/create-order', [OrderController::class, 'create'])->name('create-order');
    Route::post('/store-order', [OrderController::class, 'store'])->name('store-order');
    Route::post('/store-order-excel', [OrderController::class, 'storeOrderExcel'])->name('store-order-excel');
    Route::post('/deletedAtOrder/{id}', [OrderController::class,'deletedAt'])->name('deletedAtOrder');
});

Route::middleware(['auth','role'])->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('templates', [TemplateController::class, 'templates'])->name('templates');

    Route::get('create-template', [TemplateController::class, 'createTemplate'])->name('create-template');
    Route::post('store-template', [TemplateController::class, 'storeTemplate'])->name('store-template');

    Route::get('edit-template/{id}', [TemplateController::class, 'editTemplate'])->name('edit-template');
    Route::post('update-template', [TemplateController::class, 'updateTemplate'])->name('update-template');

    Route::get('edit-user-template/{id}', [TemplateController::class, 'editUserTemplate'])->name('edit-user-template');
    Route::post('update-user-template', [TemplateController::class, 'updateUserTemplate'])->name('update-user-template');
});
