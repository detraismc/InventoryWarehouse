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
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
| Routes accessible only to guests (unauthenticated users), such as
| the login page and login submission.
*/
Route::middleware('guest')->group(function() {
    Route::get('/login', [LoginController::class, 'index'])->name('login'); // Show login form
    Route::post('/login', [LoginController::class, 'login'])->name('login.enter'); // Handle login submission
});

/*
|--------------------------------------------------------------------------
| Admin-only Routes
|--------------------------------------------------------------------------
| Routes accessible only to users with 'admin' role, including user
| management and viewing/deleting logs.
*/
Route::middleware(['auth', 'role:admin'])->group(function () {
    // User management
    Route::get('/user', [UserController::class, 'index'])->name('inventory.user');
    Route::post('/user', [UserController::class, 'store'])->name('inventory.user.create');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('inventory.user.edit');
    Route::put('/user/{id}/password', [UserController::class, 'updatePassword'])->name('inventory.user.editpassword');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('inventory.user.delete');

    // Log management
    Route::get('/log/transaction', [LogController::class, 'transaction'])->name('inventory.log.transaction');
    Route::get('/log/account', [LogController::class, 'account'])->name('inventory.log.account');
    Route::get('/log/setup', [LogController::class, 'setup'])->name('inventory.log.setup');
    Route::delete('/log/delete/{id}', [LogController::class, 'destroy'])->name('inventory.log.delete');
});

/*
|--------------------------------------------------------------------------
| Admin & Manager Routes
|--------------------------------------------------------------------------
| Routes accessible to users with 'admin' or 'manager' roles, including
| managing warehouses, categories, and items.
*/
Route::middleware(['auth', 'role:admin,manager'])->group(function () {
    // Warehouse management
    Route::get('/warehouse', [WarehouseController::class, 'index'])->name('inventory.warehouse');
    Route::post('/warehouse', [WarehouseController::class, 'store'])->name('inventory.warehouse.create');
    Route::put('/warehouse/{id}', [WarehouseController::class, 'update'])->name('inventory.warehouse.edit');
    Route::delete('/warehouse/{id}', [WarehouseController::class, 'destroy'])->name('inventory.warehouse.delete');

    // Category management
    Route::get('/category', [CategoryController::class, 'index'])->name('inventory.category');
    Route::post('/category', [CategoryController::class, 'store'])->name('inventory.category.create');
    Route::put('/category/{id}', [CategoryController::class, 'update'])->name('inventory.category.edit');
    Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('inventory.category.delete');

    // Item management
    Route::get('/item', [ItemController::class, 'index'])->name('inventory.item');
    Route::post('/item', [ItemController::class, 'store'])->name('inventory.item.create');
    Route::post('/item/duplicate', [ItemController::class, 'duplicate'])->name('inventory.item.duplicate');
    Route::put('/item/{id}', [ItemController::class, 'update'])->name('inventory.item.edit');
    Route::delete('/item/{id}', [ItemController::class, 'destroy'])->name('inventory.item.delete');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes for All Roles (Admin, Manager, User)
|--------------------------------------------------------------------------
| Routes accessible to any authenticated user, including dashboard,
| supply management, transactions, account updates, and logout.
*/
Route::middleware(['auth', 'role:admin,manager,user'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('inventory.dashboard');

    // Supply routes
    Route::get('/supply', [SupplyController::class, 'index'])->name('inventory.supply');
    Route::get('/supply/{warehouse}', [SupplyController::class, 'show'])->name('inventory.supply.show');
    Route::post('/supply/store', [SupplyController::class, 'store'])->name('inventory.supply.store');

    // Transaction routes
    Route::get('/transaction', [TransactionController::class, 'index'])->name('inventory.transaction');
    Route::get('/transaction/completed', [TransactionController::class, 'indexCompleted'])->name('inventory.transaction.completed');
    Route::patch('/transaction/{id}/updatestage', [TransactionController::class, 'updateStage'])->name('inventory.transaction.updatestage');
    Route::delete('/transaction/{id}/delete', [TransactionController::class, 'destroy'])->name('inventory.transaction.delete');

    // Account management
    Route::get('/account', [AccountController::class, 'index'])->name('inventory.account');
    Route::put('/account/editprofile', [AccountController::class, 'updateProfile'])->name('inventory.account.editprofile');
    Route::put('/account/editpassword', [AccountController::class, 'updatePassword'])->name('inventory.account.editpassword');

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
