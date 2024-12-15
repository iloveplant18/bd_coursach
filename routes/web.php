<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DefaultController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TariffsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DefaultController::class, 'dashboard'])->name('dashboard');

Route::prefix('/rooms')->controller(RoomsController::class)->group(function () {
    Route::get('/', 'index')->name('rooms');
    Route::get('/{id}', 'show')->name('rooms.show');
});

Route::prefix('/tariffs')->controller(TariffsController::class)->group(function () {
    Route::get('/', 'index')->name('tariffs');
    Route::patch('/{tariff}', 'update')->name('tariffs.update');
});

Route::prefix('/bookings')->controller(BookingController::class)->group(function () {
    Route::get('/', 'index')
        ->middleware('auth')
        ->can('do-client-action')
        ->name('bookings');
    Route::post('/', 'store')
        ->middleware('auth')
        ->can('do-client-action')
        ->name('bookings.store');
    Route::get('/{booking}/edit', 'edit')
        ->middleware('auth')
        ->can('do-client-action')
        ->can('update-booking', 'booking')
        ->name('bookings.edit');
    Route::get('/{booking}', 'show')
        ->middleware('auth')
        ->can('do-client-action')
        ->can('update-booking', 'booking')
        ->name('bookings.show');
    Route::patch('/{booking}', 'update')
        ->middleware('auth')
        ->can('do-client-action')
        ->can('update-booking', 'booking')
        ->name('bookings.update');
    Route::delete('/{booking}', 'destroy')
        ->middleware('auth')
        ->can('do-client-action')
        ->can('update-booking', 'booking')
        ->name('bookings.destroy');
});

Route::prefix('/services')->controller(ServiceController::class)->group(function () {
    Route::get('/', 'index')->name('services');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
