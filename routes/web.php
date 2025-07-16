<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\LeaveRequestController;
use App\Http\Controllers\Web\ClaimController; // <--- TAMBAHKAN INI DI ATAS
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    // Arahkan ke halaman cuti jika sudah login
    return redirect()->route('leaves.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route untuk fitur cuti
    Route::get('/leaves', [LeaveRequestController::class, 'index'])->name('leaves.index');
    Route::post('/leaves', [LeaveRequestController::class, 'store'])->name('leaves.store');
});

Route::middleware('auth')->group(function () {
    // ... route profile dan leaves yang sudah ada

    // Route untuk fitur klaim
    Route::get('/claims', [ClaimController::class, 'index'])->name('claims.index');
    Route::post('/claims', [ClaimController::class, 'store'])->name('claims.store');
});

require __DIR__.'/auth.php';