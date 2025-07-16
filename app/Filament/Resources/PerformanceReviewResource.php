<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PerformanceReviewResource\Pages;
use App\Models\Kpi;
use App\Models\PerformanceReview;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PerformanceReviewResource extends Resource
{
    protected static ?string $model = PerformanceReview::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Performance';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Review Details')
                    ->schema([
                        Forms\Components\Select::make('employee_user_id')
                            ->label('Employee to Review')
                            ->options(
                                // Hanya tampilkan user yang merupakan bawahan dari manajer yang login
                                User::whereHas('employee', fn ($query) => $query->where('reports_to', auth()->id()))
                                    ->pluck('name', 'id')
                            )
                            ->searchable()
                            ->required(),
                        Forms\Components\DatePicker::make('review_date')
                            ->default(now())
                            ->required(),
                        Forms\Components\Hidden::make('reviewer_user_id')
                            ->default(auth()->id()),
                    ])->columns(2),

                Forms\Components\Section::make('KPI Ratings')
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('kpi_id')
                                    ->label('Key Performance Indicator (KPI)')
                                    ->options(Kpi::all()->pluck('title', 'id')) // Nanti bisa difilter per departemen
                                    ->searchable()
                                    ->required()
                                    ->distinct() // Mencegah KPI yang sama dipilih dua kali
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems(),
                                Forms\Components\Select::make('rating')
                                    ->options([
                                        1 => '1 - Needs Improvement',
                                        2 => '2 - Below Expectations',
                                        3 => '3 - Meets Expectations',
                                        4 => '4 - Exceeds Expectations',
                                        5 => '5 - Outstanding',
                                    ])
                                    ->required(),
                                Forms\Components\Textarea::make('comments')
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->addActionLabel('Add KPI'),
                    ]),
                
                Forms\Components\Section::make('Overall Summary')
                    ->schema([
                        Forms\Components\RichEditor::make('overall_comments')
                            ->label('Overall Comments')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.name')->label('Employee')->searchable(),
                Tables\Columns\TextColumn::make('reviewer.name')->label('Reviewer')->searchable(),
                Tables\Columns\TextColumn::make('review_date')->date('d M Y')->sortable(),
                Tables\Columns\TextColumn::make('status')->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            // Manajer hanya bisa melihat review yang dia buat
            return $query->where('reviewer_user_id', auth()->id());
        }

        // Admin bisa lihat semua
        return $query;
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPerformanceReviews::route('/'),
            'create' => Pages\CreatePerformanceReview::route('/create'),
            'view' => Pages\ViewPerformanceReview::route('/{record}'),
            'edit' => Pages\EditPerformanceReview::route('/{record}/edit'),
        ];
    }
}