<?php

namespace Database\Seeders;

use App\Models\OnboardingProcess;
use App\Models\OnboardingTemplate;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OnboardingProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Cari Karyawan dan Template yang relevan
        $employee = User::where('email', 'employee@hrms.com')->first();
        $template = OnboardingTemplate::where('title', 'Onboarding Karyawan Developer')->first();

        // Jika tidak ada karyawan atau template, hentikan seeder
        if (!$employee || !$template) {
            return;
        }

        // 2. Buat sesi Onboarding Process utama untuk karyawan tersebut
        $process = OnboardingProcess::create([
            'user_id' => $employee->id,
            'onboarding_template_id' => $template->id,
            'start_date' => now()->subDays(7), // Anggap dimulai 7 hari yang lalu
            'status' => 'in_progress',
        ]);

        // 3. Salin semua task dari template ke dalam proses onboarding karyawan
        foreach ($template->tasks as $index => $task) {
            $processTask = $process->tasks()->create([
                'title' => $task->title,
            ]);

            // 4. Kita buat seolah-olah 3 tugas pertama sudah selesai
            if ($index < 3) {
                $processTask->update(['completed_at' => now()->subDays(7 - $index)]);
            }
        }
    }
}