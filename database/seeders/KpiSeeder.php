<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kpi;

class KpiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kpis = [
            // KPIs for Technology Department
            [
                'title' => 'Penyelesaian Tiket Tepat Waktu',
                'description' => 'Persentase penyelesaian tiket support atau bug report sesuai dengan SLA yang ditentukan.',
                'department' => 'Technology'
            ],
            [
                'title' => 'Kualitas Kode (Code Review Score)',
                'description' => 'Skor rata-rata yang didapat dari sesi code review oleh senior atau peer. Meliputi readability, performance, dan best practice.',
                'department' => 'Technology'
            ],
            // KPIs for Marketing Department
            [
                'title' => 'Peningkatan Engagement Media Sosial',
                'description' => 'Persentase kenaikan total interaksi (likes, comments, shares) di semua platform media sosial per kuartal.',
                'department' => 'Marketing'
            ],
            [
                'title' => 'Jumlah Lead Baru dari Campaign',
                'description' => 'Jumlah prospek berkualitas yang berhasil didapatkan dari setiap kampanye marketing yang dijalankan.',
                'department' => 'Marketing'
            ],
            // KPIs for Finance Department
            [
                'title' => 'Ketepatan Laporan Keuangan Bulanan',
                'description' => 'Menyajikan laporan keuangan bulanan yang akurat dan bebas dari error sebelum tanggal 5 setiap bulannya.',
                'department' => 'Finance'
            ],
            // KPIs for Human Resources Department
            [
                'title' => 'Waktu Rata-rata Perekrutan (Time-to-Hire)',
                'description' => 'Mengukur kecepatan proses rekrutmen dari pembukaan lowongan hingga kandidat menerima tawaran kerja.',
                'department' => 'Human Resources'
            ],
        ];

        foreach ($kpis as $kpi) {
            Kpi::create($kpi);
        }
    }
}