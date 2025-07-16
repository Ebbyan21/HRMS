<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrainingCourseResource\Pages;
use App\Filament\Resources\TrainingCourseResource\RelationManagers;
use App\Models\TrainingCourse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TrainingCourseResource extends Resource
{
    protected static ?string $model = TrainingCourse::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Training';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required()->columnSpanFull(),
                Forms\Components\DatePicker::make('start_date')->required(),
                Forms\Components\DatePicker::make('end_date')->required(),
                Forms\Components\RichEditor::make('description')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('start_date')->date('d M Y'),
                Tables\Columns\TextColumn::make('end_date')->date('d M Y'),
                Tables\Columns\TextColumn::make('enrollments_count')->counts('enrollments')->label('Participants'),
            ])
            ->filters([])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
    
    public static function getRelations(): array
    {
        return [
            RelationManagers\EnrollmentsRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrainingCourses::route('/'),
            'create' => Pages\CreateTrainingCourse::route('/create'),
            'edit' => Pages\EditTrainingCourse::route('/{record}/edit'),
        ];
    }    
}