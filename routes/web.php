<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SupplyController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\LoginController;

Route::middleware('guest')->group(function() {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.enter');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('inventory.user');
    Route::post('/user', [UserController::class, 'store'])->name('inventory.user.create');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('inventory.user.edit');
    Route::put('/user/{id}/password', [UserController::class, 'updatePassword'])->name('inventory.user.editpassword');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('inventory.user.delete');
});

Route::middleware(['auth', 'role:admin,manager'])->group(function () {
    Route::get('/warehouse', [WarehouseController::class, 'index'])->name('inventory.warehouse');
    Route::post('/warehouse', [WarehouseController::class, 'store'])->name('inventory.warehouse.create');
    Route::put('/warehouse/{id}', [WarehouseController::class, 'update'])->name('inventory.warehouse.edit');
    Route::delete('/warehouse/{id}', [WarehouseController::class, 'destroy'])->name('inventory.warehouse.delete');

    Route::get('/category', [CategoryController::class, 'index'])->name('inventory.category');
    Route::post('/category', [CategoryController::class, 'store'])->name('inventory.category.create');
    Route::put('/category/{id}', [CategoryController::class, 'update'])->name('inventory.category.edit');
    Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('inventory.category.delete');

    Route::get('/item', [ItemController::class, 'index'])->name('inventory.item');
    Route::post('/item', [ItemController::class, 'storeItem'])->name('inventory.item.create');
    Route::put('/item/{id}', [ItemController::class, 'updateItem'])->name('inventory.item.edit');
    Route::delete('/item/{id}', [ItemController::class, 'destroyItem'])->name('inventory.item.delete');

    Route::get('/log', [LogController::class, 'index'])->name('inventory.log');
    Route::delete('/log/{id}', [LogController::class, 'destroy'])->name('inventory.log.delete');
});

Route::middleware(['auth', 'role:admin,manager,user'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('inventory.dashboard');
    Route::get('/supply', [SupplyController::class, 'index'])->name('inventory.supply');
    Route::get('/supply/{warehouse}', [SupplyController::class, 'show'])->name('inventory.supply.show');

    Route::get('/transaction', [TransactionController::class, 'index'])->name('inventory.transaction');

    Route::get('/account', [AccountController::class, 'index'])->name('inventory.account');
    Route::put('/account/editprofile', [AccountController::class, 'updateProfile'])->name('inventory.account.editprofile');
    Route::put('/account/editpassword', [AccountController::class, 'updatePassword'])->name('inventory.account.editpassword');

    Route::get('/help', [HelpController::class, 'index'])->name('inventory.help');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});


