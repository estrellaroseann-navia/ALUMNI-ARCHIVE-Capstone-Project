<?php

namespace App\Filament\Resources\AccountSettingResource\Pages;

use App\Filament\Resources\AccountSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccountSettings extends ListRecords
{
    protected static string $resource = AccountSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
