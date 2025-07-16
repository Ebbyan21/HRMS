<?php
namespace App\Filament\Resources;

use App\Filament\Resources\PayslipResource\Pages;
use App\Models\Payslip;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class PayslipResource extends Resource
{
    protected static ?string $model = Payslip::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Payroll';
    
    // Kita non-aktifkan form default karena logicnya beda
    public static function form(Form $form): Form { return $form; }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.user.name')->searchable(),
                Tables\Columns\TextColumn::make('pay_period_start')->date('M Y')->label('Period'),
                Tables\Columns\TextColumn::make('net_salary')->money('IDR'),
                Tables\Columns\TextColumn::make('status')->badge(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([Tables\Actions\ViewAction::make()])
            ->bulkActions([]);
    }
    
    // Infolist untuk halaman View
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('Payslip Information')
                ->schema([
                    Infolists\Components\TextEntry::make('employee.user.name'),
                    Infolists\Components\TextEntry::make('pay_period_start')->date('F Y')->label('Pay Period'),
                    Infolists\Components\TextEntry::make('status')->badge(),
                ])->columns(3),
            Infolists\Components\Section::make('Summary')
                ->schema([
                    Infolists\Components\TextEntry::make('gross_salary')->money('IDR'),
                    Infolists\Components\TextEntry::make('total_deductions')->money('IDR'),
                    Infolists\Components\TextEntry::make('net_salary')->money('IDR')->weight('bold'),
                ])->columns(3),
            Infolists\Components\Section::make('Details')
                ->schema([
                    Infolists\Components\RepeatableEntry::make('details')
                        ->schema([
                            Infolists\Components\TextEntry::make('component_name')->label('Component'),
                            Infolists\Components\TextEntry::make('amount')->money('IDR'),
                        ])
                        ->columns(2)
                ]),
        ]);
    }

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayslips::route('/'),
            'create' => Pages\CreatePayslip::route('/create'),
            'view' => Pages\ViewPayslip::route('/{record}'),
        ];
    }
}