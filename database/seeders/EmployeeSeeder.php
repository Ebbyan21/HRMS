<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // --- BIKIN 3 USER UTAMA DULU ---

        // 1. Bikin User Admin
        $adminUser = User::create([
            'name' => 'Admin HRMS',
            'email' => 'admin@hrms.com',
            'password' => Hash::make('password'), // passwordnya: "password"
        ]);
        // (Kita nggak bikinin data employee buat admin, karena dia bukan karyawan biasa)

        // 2. Bikin User Manager
        $managerUser = User::create([
            'name' => 'Budi Manajer',
            'email' => 'manager@hrms.com',
            'password' => Hash::make('password'),
        ]);
        Employee::create([
            'user_id' => $managerUser->id,
            'job_title' => 'Project Manager',
            'department' => 'Technology',
            'hire_date' => '2022-01-15',
            'phone_number' => '081234567890',
            'address' => 'Jl. Jend. Sudirman Kav. 52-53, Jakarta Selatan',
        ]);

        // 3. Bikin User Karyawan Biasa
        $employeeUser = User::create([
            'name' => 'Citra Karyawan',
            'email' => 'employee@hrms.com',
            'password' => Hash::make('password'),
        ]);
        Employee::create([
            'user_id' => $employeeUser->id,
            'job_title' => 'Frontend Developer',
            'department' => 'Technology',
            'hire_date' => '2023-03-20',
            'phone_number' => '089876543210',
            'address' => 'Jl. Gatot Subroto No. 12, Jakarta Pusat',
        ]);


        // --- SEKARANG, BIKIN 20 KARYAWAN PALSU LAINNYA ---
        User::factory(20)->create()->each(function ($user) {
            Employee::create([
                'user_id' => $user->id,
                'job_title' => fake()->jobTitle(),
                'department' => fake()->randomElement(['Technology', 'Marketing', 'Finance', 'Human Resources']),
                'hire_date' => fake()->date(),
                'phone_number' => fake()->phoneNumber(),
                'address' => fake()->address(),
            ]);
        });
    }
}