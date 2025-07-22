<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InternSeatController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/bookseat', [InternSeatController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('bookseat');

Route::get('/reservations', [ReservationController::class, 'view'])
    ->name('reservations');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
