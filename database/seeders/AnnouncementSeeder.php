<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Announcement;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@hrms.com')->first();

        if ($admin) {
            $announcements = [
                [
                    'title' => 'Libur Nasional Hari Kemerdekaan',
                    'content' => '<p>Diberitahukan kepada seluruh karyawan, dalam rangka memperingati Hari Kemerdekaan Republik Indonesia, maka pada tanggal <strong>17 Agustus 2025</strong> seluruh kegiatan kantor akan diliburkan.</p><p>Mohon untuk menyelesaikan pekerjaan yang mendesak sebelum tanggal tersebut. Terima kasih.</p>',
                    'user_id' => $admin->id,
                    'created_at' => now()->subDays(5),
                ],
                [
                    'title' => 'Peraturan Bekerja dari Kantor (WFO) Terbaru',
                    'content' => '<p>Mulai tanggal 1 September 2025, akan diberlakukan kebijakan WFO Hybrid dengan jadwal yang akan diinformasikan oleh masing-masing manajer departemen.</p><p>Pastikan untuk selalu menjaga protokol kesehatan selama berada di area kantor.</p>',
                    'user_id' => $admin->id,
                    'created_at' => now()->subDays(2),
                ],
            ];

            foreach ($announcements as $announcement) {
                Announcement::create($announcement);
            }
        }
    }
}