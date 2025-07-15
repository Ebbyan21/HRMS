<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeaveRequestResource\Pages;
use App\Models\LeaveRequest;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class LeaveRequestResource extends Resource
{
    protected static ?string $model = LeaveRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-down';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Employee Name')
                    ->disabled(),
                Forms\Components\DatePicker::make('start_date')
                    ->disabled(),
                Forms\Components\DatePicker::make('end_date')
                    ->disabled(),
                Forms\Components\Textarea::make('reason')
                    ->columnSpanFull()
                    ->disabled(),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Employee')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('reason')
                    ->limit(30)
                    ->tooltip(fn (LeaveRequest $record): string => $record->reason),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->action(function (LeaveRequest $record) {
                        $record->status = 'approved';
                        $record->approved_by = auth()->id();
                        $record->save();
                    })
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn (LeaveRequest $record) => $record->status === 'pending'),
                Tables\Actions\Action::make('reject')
                    ->action(function (LeaveRequest $record) {
                        $record->status = 'rejected';
                        $record->approved_by = auth()->id();
                        $record->save();
                    })
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->visible(fn (LeaveRequest $record) => $record->status === 'pending'),
                // Tables\Actions\ViewAction::make(), // <--- KASIH KOMEN ATAU HAPUS BARIS INI DULU
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->user()->hasRole('Manager')) {
            // Ambil ID semua user yang report ke manajer ini
            $teamUserIds = User::whereHas('employee', function ($q) {
                $q->where('reports_to', auth()->id());
            })->pluck('id');

            return $query->whereIn('user_id', $teamUserIds);
        }

        // Admin bisa lihat semua
        return $query;
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeaveRequests::route('/'),
            // 'create' => Pages\CreateLeaveRequest::route('/create'), // Create dari sisi Karyawan
            // 'edit' => Pages\EditLeaveRequest::route('/{record}/edit'), // Edit via action
        ];
    }
}