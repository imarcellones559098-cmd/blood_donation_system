<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonorProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DonorController;

// Redirect root to login
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('donor.dashboard');
    }
    return view('welcome');
});

// Donor routes (authenticated donors)
Route::middleware(['auth'])->prefix('donor')->name('donor.')->group(function () {
    Route::get('/dashboard', [DonorController::class, 'dashboard'])->name('dashboard');
    Route::get('/donate', [DonorController::class, 'create'])->name('donate');
    Route::post('/donate', [DonorController::class, 'store'])->name('store');
    Route::get('/edit/{donation}', [DonorController::class, 'edit'])->name('edit');
    Route::put('/update/{donation}', [DonorController::class, 'update'])->name('update');
    Route::delete('/delete/{donation}', [DonorController::class, 'destroy'])->name('destroy');
    Route::get('/profile', [DonorController::class, 'profile'])->name('profile');
    Route::post('/profile', [DonorController::class, 'updateProfile'])->name('profile.update');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/donors', [AdminController::class, 'donors'])->name('donors');
    Route::post('/donations/{donation}/status', [AdminController::class, 'updateStatus'])->name('donations.status');
});

require __DIR__.'/auth.php';