<?php

namespace Database\Seeders;

use App\Models\Kpi;
use App\Models\PerformanceReview;
use App\Models\ReviewItem;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PerformanceReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Cari user yang relevan
        $manager = User::where('email', 'manager@hrms.com')->first();
        $employee = User::where('email', 'employee@hrms.com')->first();

        // 2. Cari KPI yang relevan untuk departemen Technology
        $techKpis = Kpi::where('department', 'Technology')->get();

        // Jika tidak ada manajer, karyawan, atau kpi, hentikan seeder
        if (!$manager || !$employee || $techKpis->isEmpty()) {
            return;
        }

        // 3. Buat sesi Performance Review utama
        $review = PerformanceReview::create([
            'employee_user_id' => $employee->id,
            'reviewer_user_id' => $manager->id,
            'review_date' => now()->subDays(10), // 10 hari yang lalu
            'overall_comments' => '<p>Secara keseluruhan, kinerja Citra selama periode ini sangat baik. Cepat dalam belajar dan kontribusinya di proyek sangat terasa. Perlu sedikit peningkatan dalam manajemen waktu untuk task-task minor.</p>',
            'status' => 'completed',
        ]);

        // 4. Buat item skor untuk setiap KPI
        foreach ($techKpis as $kpi) {
            ReviewItem::create([
                'performance_review_id' => $review->id,
                'kpi_id' => $kpi->id,
                'rating' => rand(3, 5), // Beri skor acak antara 3 (Meets) s/d 5 (Outstanding)
                'comments' => 'Komentar untuk ' . strtolower($kpi->title) . '.',
            ]);
        }
    }
}