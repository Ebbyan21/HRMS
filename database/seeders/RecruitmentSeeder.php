<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\JobVacancy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RecruitmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Menggunakan data Faker versi Indonesia

        // 1. Buat beberapa lowongan pekerjaan
        $vacancies = collect([
            JobVacancy::create([
                'title' => 'Senior Frontend Developer (React)',
                'department' => 'Technology',
                'description' => '<p>Mencari developer frontend berpengalaman untuk membangun UI/UX yang responsif dan modern.</p>',
                'requirements' => '<ul><li>Pengalaman 3+ tahun dengan React.js</li><li>Mahir dengan Tailwind CSS</li><li>Paham state management</li></ul>',
                'status' => 'open',
                'deadline' => now()->addMonth(),
            ]),
            JobVacancy::create([
                'title' => 'Digital Marketing Specialist',
                'department' => 'Marketing',
                'description' => '<p>Bertanggung jawab untuk semua campaign digital, SEO/SEM, dan social media marketing.</p>',
                'requirements' => '<ul><li>Pengalaman di bidang digital marketing</li><li>Menguasai Google Ads & Facebook Ads</li><li>Mampu menganalisa data campaign</li></ul>',
                'status' => 'open',
                'deadline' => now()->addWeeks(2),
            ]),
            JobVacancy::create([
                'title' => 'Staff Accountant',
                'department' => 'Finance',
                'description' => '<p>Lowongan ini sudah ditutup.</p>',
                'requirements' => '<p>S1 Akuntansi.</p>',
                'status' => 'closed',
                'deadline' => now()->subWeek(),
            ]),
        ]);

        // 2. Buat 15 pelamar acak untuk lowongan yang ada
        $applicantStatuses = ['new', 'screening', 'interview', 'hired', 'rejected'];

        for ($i = 0; $i < 15; $i++) {
            Applicant::create([
                'job_vacancy_id' => $vacancies->random()->id,
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'phone' => $faker->phoneNumber(),
                'status' => $faker->randomElement($applicantStatuses),
                'notes' => 'Catatan awal untuk kandidat ini.',
            ]);
        }
    }
}