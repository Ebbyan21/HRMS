<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\LeaveRequest;

class LeaveRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manager = User::where('email', 'manager@hrms.com')->first();
        // Ambil 2 karyawan random yang bukan admin atau manajer
        $employees = User::whereNotIn('email', ['admin@hrms.com', 'manager@hrms.com'])->inRandomOrder()->limit(2)->get();

        if ($manager && $employees->count() >= 2) {
            // Contoh 1: Cuti disetujui
            LeaveRequest::create([
                'user_id' => $employees[0]->id,
                'start_date' => now()->subDays(20),
                'end_date' => now()->subDays(18),
                'reason' => 'Keperluan keluarga di luar kota.',
                'status' => 'approved',
                'approved_by' => $manager->id,
            ]);

            // Contoh 2: Cuti ditolak
            LeaveRequest::create([
                'user_id' => $employees[1]->id,
                'start_date' => now()->subDays(10),
                'end_date' => now()->subDays(10),
                'reason' => 'Sakit, surat dokter menyusul.',
                'status' => 'rejected',
                'approved_by' => $manager->id,
            ]);

            // Contoh 3: Cuti masih pending dari Citra Karyawan
            $citra = User::where('email', 'employee@hrms.com')->first();
            if ($citra) {
                LeaveRequest::create([
                    'user_id' => $citra->id,
                    'start_date' => now()->addDays(5),
                    'end_date' => now()->addDays(7),
                    'reason' => 'Mengurus administrasi pernikahan.',
                    'status' => 'pending',
                ]);
            }
        }
    }
}