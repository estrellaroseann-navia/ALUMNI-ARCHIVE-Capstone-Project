<?php

namespace App\Filament\Resources\AboutUsContentResource\Pages;

use App\Filament\Resources\AboutUsContentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAboutUsContent extends EditRecord
{
    protected static string $resource = AboutUsContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
