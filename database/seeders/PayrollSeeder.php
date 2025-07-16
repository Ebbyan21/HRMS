<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\SalaryComponent;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PayrollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat "Kamus" Komponen Gaji
        $components = collect([
            ['name' => 'Gaji Pokok', 'type' => 'allowance', 'is_fixed' => false],
            ['name' => 'Tunjangan Transport', 'type' => 'allowance', 'is_fixed' => true],
            ['name' => 'Tunjangan Makan', 'type' => 'allowance', 'is_fixed' => true],
            ['name' => 'Tunjangan Jabatan', 'type' => 'allowance', 'is_fixed' => false],
            ['name' => 'Potongan BPJS Kesehatan', 'type' => 'deduction', 'is_fixed' => false],
            ['name' => 'Potongan BPJS Ketenagakerjaan', 'type' => 'deduction', 'is_fixed' => false],
            ['name' => 'Potongan PPh 21', 'type' => 'deduction', 'is_fixed' => false],
        ]);

        $components->each(fn ($component) => SalaryComponent::create($component));

        // 2. Setup Gaji untuk Karyawan Tertentu
        $employeeCitra = Employee::whereHas('user', fn ($q) => $q->where('email', 'employee@hrms.com'))->first();
        $managerBudi = Employee::whereHas('user', fn ($q) => $q->where('email', 'manager@hrms.com'))->first();
        
        // Setup untuk Citra Karyawan
        if ($employeeCitra) {
            $this->assignSalary($employeeCitra, [
                'Gaji Pokok' => 8000000,
                'Tunjangan Transport' => 500000,
                'Tunjangan Makan' => 600000,
                'Potongan BPJS Kesehatan' => 80000, // 1% dari Gaji Pokok
            ]);
        }
        
        // Setup untuk Budi Manajer
        if ($managerBudi) {
            $this->assignSalary($managerBudi, [
                'Gaji Pokok' => 15000000,
                'Tunjangan Jabatan' => 2000000,
                'Tunjangan Transport' => 750000,
                'Tunjangan Makan' => 800000,
                'Potongan BPJS Kesehatan' => 150000, // 1% dari Gaji Pokok
            ]);
        }
    }

    /**
     * Helper function to assign salary components to an employee.
     */
    private function assignSalary(Employee $employee, array $salaries): void
    {
        foreach ($salaries as $componentName => $amount) {
            $component = SalaryComponent::where('name', $componentName)->first();
            if ($component) {
                $employee->salaries()->create([
                    'salary_component_id' => $component->id,
                    'amount' => $amount,
                ]);
            }
        }
    }
}