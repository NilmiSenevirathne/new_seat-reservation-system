<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InternSeatController;
use App\Http\Controllers\AdminSeatController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SeatBookingController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


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


Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('managereservations', App\Http\Controllers\Admin\AdminReservationController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/reports', [ReportsController::class, 'index'])->name('admin.reports');
        Route::get('/reports/export', [ReportsController::class, 'export'])->name('admin.reports.export');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::post('/book-seat', [SeatBookingController::class, 'book'])->name('seat.book');
});


Route::get('/reservations', [ReservationController::class, 'view'])->name('reservations.index');
Route::post('/reservations/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
