<?php
namespace App\Services;
use App\Models\Employee;
use App\Models\Payslip;
use Carbon\Carbon;

class PayrollService
{
    public function generatePayslip(Employee $employee, string $period): Payslip
    {
        $payPeriod = Carbon::parse($period);
        $startDate = $payPeriod->copy()->startOfMonth();
        $endDate = $payPeriod->copy()->endOfMonth();

        $grossSalary = 0;
        $totalDeductions = 0;
        $details = [];

        // Ambil semua komponen gaji karyawan beserta nama komponennya
        $salaryComponents = $employee->salaries()->with('salaryComponent')->get();

        foreach ($salaryComponents as $component) {
            $details[] = [
                'component_name' => $component->salaryComponent->name,
                'component_type' => $component->salaryComponent->type,
                'amount' => $component->amount,
            ];

            if ($component->salaryComponent->type === 'allowance') {
                $grossSalary += $component->amount;
            } else {
                $totalDeductions += $component->amount;
            }
        }

        $netSalary = $grossSalary - $totalDeductions;

        // 1. Buat record Payslip utama
        $payslip = Payslip::create([
            'employee_id' => $employee->id,
            'pay_period_start' => $startDate,
            'pay_period_end' => $endDate,
            'gross_salary' => $grossSalary,
            'total_deductions' => $totalDeductions,
            'net_salary' => $netSalary,
            'status' => 'published',
        ]);

        // 2. Buat record detailnya
        $payslip->details()->createMany($details);

        return $payslip;
    }
}