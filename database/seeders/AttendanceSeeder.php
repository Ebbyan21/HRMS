<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua user yang bukan admin
        $employees = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'Admin');
        })->get();

        // Tentukan periode waktu (30 hari terakhir)
        $endDate = Carbon::today();
        $startDate = $endDate->copy()->subDays(30);

        foreach ($employees as $employee) {
            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                // Lewati hari Sabtu & Minggu
                if ($date->isWeekend()) {
                    continue;
                }

                // Beri kemungkinan 10% karyawan tidak masuk di hari kerja
                if (rand(1, 10) == 1) {
                    continue;
                }

                // Generate waktu clock-in acak (antara 08:00 - 09:30)
                $clockInHour = rand(8, 9);
                $clockInMinute = ($clockInHour == 9) ? rand(0, 0) : rand(0, 59);
                $clockInSecond = rand(0, 59);
                $clockInTime = $date->copy()->setTime($clockInHour, $clockInMinute, $clockInSecond);

                // Generate waktu clock-out acak (antara 17:00 - 18:00)
                $clockOutHour = rand(17, 18);
                $clockOutMinute = ($clockOutHour == 18) ? rand(0, 0) : rand(0, 59);
                $clockOutSecond = rand(0, 59);
                $clockOutTime = $date->copy()->setTime($clockOutHour, $clockOutMinute, $clockOutSecond);
                
                // Tentukan status berdasarkan jam masuk (lewat dari jam 9 dianggap telat)
                $status = $clockInTime->hour >= 9 ? 'Late' : 'Present';

                Attendance::create([
                    'user_id' => $employee->id,
                    'date' => $date->toDateString(),
                    'clock_in_time' => $clockInTime,
                    'clock_out_time' => $clockOutTime,
                    'status' => $status,
                ]);
            }
        }
    }
}