<?php

namespace App\Filament\Resources\OnboardingProcessResource\Pages;

use App\Filament\Resources\OnboardingProcessResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOnboardingProcesses extends ListRecords
{
    protected static string $resource = OnboardingProcessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
