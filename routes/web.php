<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\LeaveRequestController;
use App\Http\Controllers\Web\ClaimController;
use App\Http\Controllers\Web\AttendanceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// PERUBAHAN 1: Pas buka localhost, langsung lempar ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// PERUBAHAN 2: Setelah login, beneran ke halaman dashboard dulu
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route untuk fitur cuti
    Route::get('/leaves', [LeaveRequestController::class, 'index'])->name('leaves.index');
    Route::post('/leaves', [LeaveRequestController::class, 'store'])->name('leaves.store');

    // Route untuk fitur klaim
    Route::get('/claims', [ClaimController::class, 'index'])->name('claims.index');
    Route::post('/claims', [ClaimController::class, 'store'])->name('claims.store');

    // Route untuk Absensi
    Route::post('/attendance/clock-in', [AttendanceController::class, 'clockIn'])->name('attendance.clock-in');
    Route::post('/attendance/clock-out', [AttendanceController::class, 'clockOut'])->name('attendance.clock-out');
});

require __DIR__.'/auth.php';