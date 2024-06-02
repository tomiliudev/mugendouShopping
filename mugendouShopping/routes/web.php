<?php

use App\Http\Controllers\user\CartController;
use App\Http\Controllers\user\ItemController;
use App\Http\Controllers\user\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('user/welcome');
});

Route::middleware('auth:user')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/', [ItemController::class, 'index'])->name('item.index');
    Route::get('/show/{product}', [ItemController::class, 'show'])->name('item.show');

    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    });
});

require __DIR__ . '/auth.php';
