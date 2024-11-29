<?php

namespace App\Filament\Resources\AccountSettingResource\Pages;

use App\Filament\Resources\AccountSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccountSetting extends EditRecord
{
    protected static string $resource = AccountSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
