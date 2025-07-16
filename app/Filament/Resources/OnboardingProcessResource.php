<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OnboardingProcessResource\Pages;
use App\Models\OnboardingProcess;
use App\Models\OnboardingTemplate;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class OnboardingProcessResource extends Resource
{
    protected static ?string $model = OnboardingProcess::class;

    protected static ?string $navigationIcon = 'heroicon-o-rocket-launch';
    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Employee')
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->createOptionForm(null) // Nonaktifkan pembuatan user baru dari sini
                    ->disabledOn('edit'),
                Forms\Components\Select::make('onboarding_template_id')
                    ->label('Onboarding Template')
                    ->options(OnboardingTemplate::all()->pluck('title', 'id'))
                    ->required()
                    ->disabledOn('edit'),
                Forms\Components\DatePicker::make('start_date')
                    ->default(now())
                    ->required(),
                
                Forms\Components\Section::make('Checklist Progress')
                    ->schema([
                        Forms\Components\Repeater::make('tasks')
                            ->relationship()
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->disabled(),
                                Forms\Components\Checkbox::make('completed_at')
                                    ->label('Completed')
                                    // Konversi nilai checkbox ke datetime
                                    ->dehydrateStateUsing(fn ($state) => $state ? now() : null)
                                    ->hydrateStateUsing(fn ($state) => $state !== null),
                            ])
                            ->columns(2)
                            ->addable(false) // Sembunyikan tombol "Add"
                            ->deletable(false) // Sembunyikan tombol "Delete"
                    ])->visibleOn('edit')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Employee')->searchable(),
                Tables\Columns\TextColumn::make('template.title')->label('Template'),
                Tables\Columns\TextColumn::make('start_date')->date('d M Y'),
                Tables\Columns\TextColumn::make('status')->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(), // Kita pakai Edit untuk update checklist
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // LOGIKA UTAMA: Saat proses dibuat, salin task dari template
    public static function afterCreate(Model $record, array $data): void
    {
        $template = OnboardingTemplate::find($data['onboarding_template_id']);
        if ($template) {
            foreach ($template->tasks as $task) {
                $record->tasks()->create([
                    'title' => $task->title,
                ]);
            }
        }
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOnboardingProcesses::route('/'),
            'create' => Pages\CreateOnboardingProcess::route('/create'),
            'edit' => Pages\EditOnboardingProcess::route('/{record}/edit'),
        ];
    }
}