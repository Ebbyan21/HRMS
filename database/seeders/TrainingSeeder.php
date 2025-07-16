<?php

namespace Database\Seeders;

use App\Models\TrainingCourse;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrainingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ambil beberapa karyawan untuk didaftarkan
        $employees = User::whereNotIn('email', ['admin@hrms.com'])->get();

        if ($employees->isEmpty()) {
            return;
        }

        // 2. Buat beberapa data pelatihan
        $course1 = TrainingCourse::create([
            'name' => 'Dasar-Dasar Laravel 11 untuk Pemula',
            'description' => '<p>Pelatihan intensif untuk memahami konsep dasar dan fundamental dari framework Laravel 11.</p>',
            'start_date' => now()->addMonth(),
            'end_date' => now()->addMonth()->addDays(5),
        ]);

        $course2 = TrainingCourse::create([
            'name' => 'Teknik SEO & SEM Lanjutan',
            'description' => '<p>Meningkatkan skill dalam optimasi mesin pencari dan marketing berbayar untuk meningkatkan visibilitas brand.</p>',
            'start_date' => now()->addWeeks(2),
            'end_date' => now()->addWeeks(2)->addDays(2),
        ]);
        
        $course3 = TrainingCourse::create([
            'name' => 'Public Speaking untuk Profesional',
            'description' => '<p>Pelatihan untuk meningkatkan kepercayaan diri dan kemampuan berbicara di depan umum.</p>',
            'start_date' => now()->subMonth(), // Pelatihan yang sudah lewat
            'end_date' => now()->subMonth()->addDays(1),
        ]);

        // 3. Daftarkan karyawan ke pelatihan
        
        // Daftarkan 3 karyawan ke pelatihan Laravel
        foreach ($employees->random(3) as $employee) {
            $course1->enrollments()->create([
                'user_id' => $employee->id,
                'status' => 'enrolled',
            ]);
        }

        // Daftarkan 2 karyawan ke pelatihan SEO
        foreach ($employees->random(2) as $employee) {
            $course2->enrollments()->create([
                'user_id' => $employee->id,
                'status' => 'enrolled',
            ]);
        }

        // Daftarkan 4 karyawan ke pelatihan Public Speaking yang sudah selesai
        foreach ($employees->random(4) as $employee) {
            $course3->enrollments()->create([
                'user_id' => $employee->id,
                'status' => 'completed',
            ]);
        }
    }
}