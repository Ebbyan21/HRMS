<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function clockIn(): RedirectResponse
    {
        $user = auth()->user();
        $today = Carbon::today()->toDateString();

        // Cek apakah sudah clock in hari ini
        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        if ($attendance) {
            return redirect()->back()->with('error', 'Anda sudah melakukan clock-in hari ini.');
        }

        // Simpan data clock in
        Attendance::create([
            'user_id' => $user->id,
            'date' => $today,
            'clock_in_time' => now(),
            'status' => 'Present', // Nanti bisa dikembangkan dengan status "Late"
        ]);

        return redirect()->back()->with('success', 'Berhasil clock-in. Selamat bekerja!');
    }

    public function clockOut(): RedirectResponse
    {
        $user = auth()->user();
        $today = Carbon::today()->toDateString();

        // Cari data clock in hari ini
        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        // Jika belum clock in atau sudah clock out
        if (!$attendance || $attendance->clock_out_time) {
            return redirect()->back()->with('error', 'Anda belum clock-in atau sudah melakukan clock-out hari ini.');
        }

        // Update data clock out
        $attendance->update([
            'clock_out_time' => now(),
        ]);

        return redirect()->back()->with('success', 'Berhasil clock-out. Sampai jumpa besok!');
    }
}