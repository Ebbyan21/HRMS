<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role; // <-- TAMBAHKAN INI

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat Roles dulu
        $adminRole = Role::create(['name' => 'Admin']);
        $managerRole = Role::create(['name' => 'Manager']);
        $employeeRole = Role::create(['name' => 'Employee']);

        // 1. Bikin User Admin
        $adminUser = User::create([
            'name' => 'Admin HRMS',
            'email' => 'admin@hrms.com',
            'password' => Hash::make('password'),
        ]);
        $adminUser->assignRole($adminRole);

        // 2. Bikin User Manager
        $managerUser = User::create([
            'name' => 'Budi Manajer',
            'email' => 'manager@hrms.com',
            'password' => Hash::make('password'),
        ]);
        $managerUser->assignRole($managerRole);
        Employee::create([
            'user_id' => $managerUser->id,
            'job_title' => 'Project Manager',
            'department' => 'Technology',
            'hire_date' => '2022-01-15',
        ]);

        // 3. Bikin User Karyawan Biasa di bawah Budi
        $employeeUser = User::create([
            'name' => 'Citra Karyawan',
            'email' => 'employee@hrms.com',
            'password' => Hash::make('password'),
        ]);
        $employeeUser->assignRole($employeeRole);
        Employee::create([
            'user_id' => $employeeUser->id,
            'job_title' => 'Frontend Developer',
            'department' => 'Technology',
            'hire_date' => '2023-03-20',
            'reports_to' => $managerUser->id, // Citra lapor ke Budi
        ]);

        // Bikin 20 karyawan palsu lainnya, lapor ke Budi juga
        User::factory(20)->create()->each(function ($user) use ($employeeRole, $managerUser) {
            $user->assignRole($employeeRole);
            Employee::create([
                'user_id' => $user->id,
                'job_title' => fake()->jobTitle(),
                'department' => 'Technology',
                'hire_date' => fake()->date(),
                'reports_to' => $managerUser->id, // Semua lapor ke Budi
            ]);
        });
    }
}