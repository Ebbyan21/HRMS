<?php

namespace App\Filament\Resources\ClaimResource\Pages;

use App\Filament\Resources\ClaimResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord; // <--- GANTI INI

class ViewClaim extends ViewRecord // <--- DAN GANTI INI
{
    protected static string $resource = ClaimResource::class;
}