<?php

namespace App\Filament\Widgets;

use App\Models\Employee;
use App\Models\LeaveRequest;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class HrmsStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Karyawan', Employee::count())
                ->description('Jumlah seluruh karyawan aktif')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Cuti Pending', LeaveRequest::where('status', 'pending')->count())
                ->description('Pengajuan cuti yang perlu diproses')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('warning'),
            Stat::make('Karyawan Baru Bulan Ini', Employee::where('hire_date', '>=', now()->startOfMonth())->count())
                ->description('Karyawan yang bergabung bulan ini')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
        ];
    }
}