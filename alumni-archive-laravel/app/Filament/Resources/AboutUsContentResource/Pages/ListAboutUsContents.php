<?php

namespace App\Filament\Resources\AboutUsContentResource\Pages;

use App\Filament\Resources\AboutUsContentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAboutUsContents extends ListRecords
{
    protected static string $resource = AboutUsContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
