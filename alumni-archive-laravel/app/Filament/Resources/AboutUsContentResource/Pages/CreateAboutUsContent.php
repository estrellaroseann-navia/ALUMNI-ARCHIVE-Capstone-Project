<?php

namespace App\Filament\Resources\AboutUsContentResource\Pages;

use App\Filament\Resources\AboutUsContentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAboutUsContent extends CreateRecord
{
    protected static string $resource = AboutUsContentResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
