<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InternSeatController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AdminSeatController;
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

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/seats', [AdminSeatController::class, 'indexA'])->name('admin.seats');
    Route::post('/admin/seats', [AdminSeatController::class, 'store'])->name('admin.seats.store');
    Route::put('/admin/seats/{id}', [AdminSeatController::class, 'update'])->name('admin.seats.update');
    Route::delete('/admin/seats/{id}', [AdminSeatController::class, 'destroy'])->name('admin.seats.destroy');
});

Route::get('/admin/seats/next-seat-number/{location}', [App\Http\Controllers\AdminSeatController::class, 'getNextSeatNumber'])->name('admin.seats.next');


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('reservations', App\Http\Controllers\Admin\ReservationController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
