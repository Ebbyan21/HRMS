<?php
namespace App\Filament\Resources\PayslipResource\Pages;

use App\Filament\Resources\PayslipResource;
use App\Models\Employee;
use App\Services\PayrollService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreatePayslip extends CreateRecord
{
    protected static string $resource = PayslipResource::class;

    // Kustomisasi form pembuatan
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employee_id')
                    ->label('Select Employee')
                    ->options(Employee::with('user')->get()->pluck('user.name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\DatePicker::make('period')
                    ->label('Select Pay Period')
                    ->default(now()->subMonth()) // Defaultnya bulan lalu
                    ->maxDate(now())
                    ->required(),
            ]);
    }
    
    // Override method create untuk memanggil service
    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $payrollService = new PayrollService();
        $employee = Employee::find($data['employee_id']);
        
        $payslip = $payrollService->generatePayslip($employee, $data['period']);

        Notification::make()
            ->title('Payslip generated successfully!')
            ->success()
            ->send();
            
        return $payslip;
    }
}