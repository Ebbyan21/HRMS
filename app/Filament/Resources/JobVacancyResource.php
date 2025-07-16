<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobVacancyResource\Pages;
use App\Models\JobVacancy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JobVacancyResource extends Resource
{
    protected static ?string $model = JobVacancy::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Recruitment';
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required()->columnSpanFull(),
                Forms\Components\Select::make('department')
                    ->options([
                        'Technology' => 'Technology',
                        'Marketing' => 'Marketing',
                        'Finance' => 'Finance',
                        'Human Resources' => 'Human Resources',
                    ])->required(),
                Forms\Components\Select::make('status')
                    ->options(['open' => 'Open', 'closed' => 'Closed'])->required()->default('open'),
                Forms\Components\DatePicker::make('deadline')->required(),
                Forms\Components\RichEditor::make('description')->required()->columnSpanFull(),
                Forms\Components\RichEditor::make('requirements')->required()->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('department'),
                Tables\Columns\TextColumn::make('status')->badge(),
                Tables\Columns\TextColumn::make('deadline')->date('d M Y'),
                Tables\Columns\TextColumn::make('applicants_count')->counts('applicants')->label('Applicants'),
            ])
            ->filters([])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\ViewAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
    
    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobVacancies::route('/'),
            'create' => Pages\CreateJobVacancy::route('/create'),
            'edit' => Pages\EditJobVacancy::route('/{record}/edit'),
            'view' => Pages\ViewJobVacancy::route('/{record}'),
        ];
    }
}