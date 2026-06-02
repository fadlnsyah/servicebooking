<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MyBookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportExportController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AdminSettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service:slug}', [ServiceController::class, 'show'])->name('services.show');

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('/services/{service:slug}/book', [ServiceController::class, 'book'])->name('services.book');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}/success', [BookingController::class, 'success'])->name('bookings.success');

    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/my-bookings', [MyBookingController::class, 'index'])->name('bookings.index');
    Route::get('/my-bookings/{booking}', [MyBookingController::class, 'show'])->name('bookings.show');
    Route::patch('/my-bookings/{booking}/cancel', [MyBookingController::class, 'cancel'])->name('bookings.cancel');
    Route::patch('/my-bookings/{booking}/reschedule', [MyBookingController::class, 'reschedule'])->name('bookings.reschedule');
    Route::post('/my-bookings/{booking}/review', [MyBookingController::class, 'review'])->name('bookings.review');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function (): void {
    Route::patch('/settings', [AdminSettingsController::class, 'update'])->name('admin.settings.update');
});

Route::middleware(['auth', 'role_or_permission:admin|provider'])->prefix('admin')->group(function (): void {
    Route::get('/reports/export/pdf', [ReportExportController::class, 'pdf'])->name('admin.reports.export.pdf');
    Route::get('/reports/export/excel', [ReportExportController::class, 'excel'])->name('admin.reports.export.excel');
});

require __DIR__.'/auth.php';
