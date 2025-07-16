<?php

namespace Database\Seeders;

use App\Models\OnboardingTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OnboardingTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            [
                'title' => 'Onboarding Karyawan Developer',
                'description' => 'Checklist standar untuk semua developer baru yang bergabung dengan tim Teknologi.',
                'tasks' => [
                    ['title' => 'Siapkan Laptop & konfigurasi awal'],
                    ['title' => 'Buat akun email perusahaan'],
                    ['title' => 'Request akses ke repository GitHub/GitLab'],
                    ['title' => 'Setup environment development lokal (Docker/Laragon)'],
                    ['title' => 'Install IDE dan tools yang dibutuhkan (VS Code, DBeaver, dll)'],
                    ['title' => 'Briefing arsitektur proyek oleh Tech Lead'],
                    ['title' => 'Perkenalan dengan anggota tim Teknologi lainnya'],
                ]
            ],
            [
                'title' => 'Onboarding Karyawan Marketing',
                'description' => 'Checklist standar untuk semua anggota tim Marketing baru.',
                'tasks' => [
                    ['title' => 'Siapkan Laptop & konfigurasi awal'],
                    ['title' => 'Buat akun email perusahaan'],
                    ['title' => 'Berikan akses ke semua akun Media Sosial perusahaan'],
                    ['title' => 'Berikan akses ke tool Analytics (Google Analytics, etc)'],
                    ['title' => 'Briefing target audience & brand guideline'],
                    ['title' => 'Review performa campaign sebelumnya dengan Marketing Manager'],
                    ['title' => 'Perkenalan dengan tim Sales dan Produk'],
                ]
            ],
        ];

        foreach ($templates as $templateData) {
            // 1. Buat Template utamanya
            $template = OnboardingTemplate::create([
                'title' => $templateData['title'],
                'description' => $templateData['description'],
            ]);

            // 2. Buat Task yang berhubungan dengan template itu
            foreach ($templateData['tasks'] as $index => $taskData) {
                $template->tasks()->create([
                    'title' => $taskData['title'],
                    'order' => $index + 1,
                ]);
            }
        }
    }
}