<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Ambil semua data employee beserta relasi user-nya
        return Employee::with('user')->get();
    }

    /**
     * @var Employee $employee
     */
    public function map($employee): array
    {
        // Mapping data yang mau ditampilkan di setiap baris
        return [
            $employee->user->id,
            $employee->user->name,
            $employee->user->email,
            $employee->job_title,
            $employee->department,
            $employee->hire_date,
            $employee->phone_number,
        ];
    }

    public function headings(): array
    {
        // Definisikan nama-nama kolom di file Excel
        return [
            'ID Karyawan',
            'Nama Lengkap',
            'Email',
            'Jabatan',
            'Departemen',
            'Tanggal Masuk',
            'Nomor HP',
        ];
    }
}