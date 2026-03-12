<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\DispatcherController;
use App\Http\Controllers\MasterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Публичная страница — создание заявки (доступна всем)
Route::get('/', [RequestController::class, 'create'])->name('requests.create');
Route::post('/', [RequestController::class, 'store'])->name('requests.store');

// Авторизация (только вход, без регистрации)
Route::get('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::post('/logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Защищённые маршруты (только для авторизованных)
Route::middleware('auth')->group(function () {

    // Панель диспетчера (доступ только для диспетчера)
    Route::get('/dispatcher', [DispatcherController::class, 'index'])
        ->middleware('role:dispatcher')
        ->name('dispatcher.dashboard');

    Route::patch('/requests/{request}/assign', [DispatcherController::class, 'assign'])
        ->middleware('role:dispatcher')
        ->name('requests.assign');

    Route::patch('/requests/{request}/cancel', [DispatcherController::class, 'cancel'])
        ->middleware('role:dispatcher')
        ->name('requests.cancel');

    // Панель мастера (доступ только для мастера)
    Route::get('/master', [MasterController::class, 'index'])
        ->middleware('role:master')
        ->name('master.dashboard');

    Route::patch('/requests/{request}/take', [MasterController::class, 'take'])
        ->middleware('role:master')
        ->name('requests.take');

    Route::patch('/requests/{request}/complete', [MasterController::class, 'complete'])
        ->middleware('role:master')
        ->name('requests.complete');

    // Профиль (для всех авторизованных)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
