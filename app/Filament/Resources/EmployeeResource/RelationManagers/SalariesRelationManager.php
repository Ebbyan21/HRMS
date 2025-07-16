<?php
namespace App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\SalaryComponent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
class SalariesRelationManager extends RelationManager
{
    protected static string $relationship = 'salaries';
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('salary_component_id')
                    ->label('Component')
                    ->options(SalaryComponent::all()->pluck('name', 'id'))
                    ->required(),
                Forms\Components\TextInput::make('amount')->numeric()->prefix('Rp')->required(),
            ]);
    }
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('salary_component_id')
            ->columns([
                Tables\Columns\TextColumn::make('salaryComponent.name'),
                Tables\Columns\TextColumn::make('salaryComponent.type')->badge(),
                Tables\Columns\TextColumn::make('amount')->money('IDR'),
            ])
            ->headerActions([Tables\Actions\CreateAction::make()])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
}