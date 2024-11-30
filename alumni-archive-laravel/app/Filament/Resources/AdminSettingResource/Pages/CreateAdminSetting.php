<?php

namespace App\Filament\Resources\AdminSettingResource\Pages;

use App\Filament\Resources\AdminSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAdminSetting extends CreateRecord
{
    protected static string $resource = AdminSettingResource::class;


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
