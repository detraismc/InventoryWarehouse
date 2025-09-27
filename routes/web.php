<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SupplyController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\LoginController;

Route::get('/', [DashboardController::class, 'index'])->name('inventory.dashboard');
Route::get('/supply', [SupplyController::class, 'index'])->name('inventory.supply');
Route::get('/transaction', [TransactionController::class, 'index'])->name('inventory.transaction');
Route::get('/warehouse', [WarehouseController::class, 'index'])->name('inventory.warehouse');
Route::get('/category', [CategoryController::class, 'index'])->name('inventory.category');
Route::get('/items', [ItemsController::class, 'index'])->name('inventory.items');
Route::get('/log', [LogController::class, 'index'])->name('inventory.log');
Route::get('/account', [AccountController::class, 'index'])->name('inventory.account');
Route::get('/help', [HelpController::class, 'index'])->name('inventory.help');
Route::get('/login', [LoginController::class, 'index'])->name('login');
