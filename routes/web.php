<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonorProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\Donor\BloodRequestController as DonorRequestController;
use App\Http\Controllers\Admin\BloodRequestController as AdminRequestController;
use App\Http\Controllers\Admin\BloodInventoryController;

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

// ── DONOR ROUTES ──────────────────────────────────
Route::middleware(['auth'])->prefix('donor')->name('donor.')->group(function () {
    Route::get('/dashboard', [DonorController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile',  [DonorController::class, 'profile'])->name('profile');
    Route::post('/profile', [DonorController::class, 'updateProfile'])->name('profile.update');

    // 🩸 Blood Requests (NEW)
    Route::get('/requests',                           [DonorRequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/create',                    [DonorRequestController::class, 'create'])->name('requests.create');
    Route::post('/requests',                          [DonorRequestController::class, 'store'])->name('requests.store');
    Route::delete('/requests/{bloodRequest}',         [DonorRequestController::class, 'destroy'])->name('requests.destroy');
});

// ── ADMIN ROUTES ──────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/donors',    [AdminController::class, 'donors'])->name('donors');
    Route::post('/donations/{donation}/status', [AdminController::class, 'updateStatus'])->name('donations.status');

    // 🩸 Admin Record Donation (NEW)
    Route::get('/donations/create', [AdminController::class, 'createDonation'])->name('donations.create');
    Route::post('/donations',       [AdminController::class, 'storeDonation'])->name('donations.store');

    // 🩸 Admin Blood Requests (NEW)
    Route::get('/requests',                   [AdminRequestController::class, 'index'])->name('requests.index');
    Route::put('/requests/{bloodRequest}',    [AdminRequestController::class, 'update'])->name('requests.update');

    // 🩸 Admin Blood Inventory (NEW)
    Route::get('/inventory',                   [BloodInventoryController::class, 'index'])->name('inventory.index');
    Route::put('/inventory/{inventory}',       [BloodInventoryController::class, 'update'])->name('inventory.update');

});

require __DIR__.'/auth.php';