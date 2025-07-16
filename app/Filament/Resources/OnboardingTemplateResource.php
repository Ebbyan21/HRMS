<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OnboardingTemplateResource\Pages;
use App\Models\OnboardingTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OnboardingTemplateResource extends Resource
{
    protected static ?string $model = OnboardingTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Settings'; // Kita grup di menu Settings

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\Section::make('Checklist Tasks')
                    ->schema([
                        Forms\Components\Repeater::make('tasks')
                            ->relationship()
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Task Name')
                                    ->required(),
                            ])
                            ->addActionLabel('Add Task')
                            ->reorderableWithDragAndDrop('order') // Bisa di-drag & drop untuk urutan
                            ->defaultItems(1)
                            ->columns(1),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('tasks_count')->counts('tasks')->label('Total Tasks'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOnboardingTemplates::route('/'),
            'create' => Pages\CreateOnboardingTemplate::route('/create'),
            'edit' => Pages\EditOnboardingTemplate::route('/{record}/edit'),
        ];
    }
}