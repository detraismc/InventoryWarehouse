<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SupplyController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\LoginController;

Route::get('/', [DashboardController::class, 'index'])->name('inventory.dashboard');
Route::get('/supply', [SupplyController::class, 'index'])->name('inventory.supply');
Route::get('/transaction', [TransactionController::class, 'index'])->name('inventory.transaction');

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


Route::get('/account', [AccountController::class, 'index'])->name('inventory.account');
Route::get('/help', [HelpController::class, 'index'])->name('inventory.help');
Route::get('/login', [LoginController::class, 'index'])->name('login');
