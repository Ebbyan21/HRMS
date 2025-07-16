<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manager = User::where('email', 'manager@hrms.com')->first();
        $employee = User::where('email', 'employee@hrms.com')->first();

        Asset::create([
            'name' => 'Macbook Pro 14" M3',
            'serial_number' => 'MBP14M3-001',
            'purchase_date' => '2024-01-10',
            'purchase_cost' => 35000000,
            'status' => 'in_use',
            'assigned_to_user_id' => $manager?->id,
        ]);

        Asset::create([
            'name' => 'Dell Latitude 7420',
            'serial_number' => 'DELL7420-005',
            'purchase_date' => '2023-05-20',
            'purchase_cost' => 22000000,
            'status' => 'in_use',
            'assigned_to_user_id' => $employee?->id,
        ]);

        Asset::create([
            'name' => 'Logitech MX Master 3S',
            'serial_number' => 'MXM3S-010',
            'purchase_date' => '2024-02-01',
            'purchase_cost' => 1500000,
            'status' => 'available',
        ]);
    }
}