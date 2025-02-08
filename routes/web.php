<?php

use App\Http\Controllers\CreditCardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImpersonateController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/impersonate/leave', [ImpersonateController::class, 'leave'])
        ->name('impersonate.leave');

    Route::post('/impersonate/{user}', [ImpersonateController::class, 'impersonate'])
        ->name('impersonate');
});

Route::get('/credit-card', CreditCardController::class)
    ->middleware(['auth', 'impersonate.secure'])
    ->name('credit-card');

require __DIR__.'/auth.php';
