<?php
namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceResource\Pages;
use App\Models\Attendance;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationGroup = 'Time Management';

    public static function form(Form $form): Form { return $form; } // Read-only

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('date')->date('d M Y')->sortable(),
                Tables\Columns\TextColumn::make('clock_in_time')->dateTime('H:i:s'),
                Tables\Columns\TextColumn::make('clock_out_time')->dateTime('H:i:s'),
                Tables\Columns\TextColumn::make('status')->badge(),
            ])
            ->filters([
                // Nanti bisa ditambah filter per tanggal
            ])
            ->actions([Tables\Actions\ViewAction::make()])
            ->bulkActions([]);
    }
    
    public static function getPages(): array
    {
        return ['index' => Pages\ListAttendances::route('/'), 'view' => Pages\ViewAttendance::route('/{record}')];
    }
}