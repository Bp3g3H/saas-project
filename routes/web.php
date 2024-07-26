<?php

use App\Http\Controllers\CreditController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeatureOneController;
use App\Http\Controllers\FeatureTwoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'Index'])->name('home');

Route::post('/buy-credits/webhook', [CreditController::class, 'webhook'])->name('credit.webhook');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/featureOne', [FeatureOneController::class, 'index'])->name('featureOne.index');
    Route::get('/featureTwo', [FeatureTwoController::class, 'index'])->name('featureTwo.index');

    Route::post('/featureOne', [FeatureOneController::class, 'calculate'])->name('featureOne.calculate');
    Route::post('/featureTwo', [FeatureTwoController::class, 'calculate'])->name('featureTwo.calculate');

    Route::get('/buy-credits', [CreditController::class, 'index'])->name('credit.index');
    Route::get('/buy-credits/success', [CreditController::class, 'success'])->name('credit.success');
    Route::get('/buy-credits/cancel', [CreditController::class, 'cancel'])->name('credit.cancel');
    Route::post('/buy-credits/{package}', [CreditController::class, 'buyCredits'])->name('credit.buy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
