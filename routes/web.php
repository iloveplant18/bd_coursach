<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\TariffsController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'dashboard');
Route::view('/dashboard', 'dashboard')->name('dashboard');

Route::prefix('/rooms')->controller(RoomsController::class)->group(function () {
    Route::get('/', 'index')->name('rooms');
    Route::get('/{id}', 'show')->name('rooms.show');
});

Route::controller(TariffsController::class)->group(function () {
    Route::get('/tariffs', 'index')->name('tariffs');
    Route::patch('/tariffs/{tariff}', 'update')->name('tariffs.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
