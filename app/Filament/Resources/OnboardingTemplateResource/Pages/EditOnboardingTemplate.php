<?php

namespace App\Filament\Resources\OnboardingTemplateResource\Pages;

use App\Filament\Resources\OnboardingTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOnboardingTemplate extends EditRecord
{
    protected static string $resource = OnboardingTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
