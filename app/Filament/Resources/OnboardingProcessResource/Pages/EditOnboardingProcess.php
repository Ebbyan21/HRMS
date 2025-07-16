<?php

namespace App\Filament\Resources\OnboardingProcessResource\Pages;

use App\Filament\Resources\OnboardingProcessResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOnboardingProcess extends EditRecord
{
    protected static string $resource = OnboardingProcessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
