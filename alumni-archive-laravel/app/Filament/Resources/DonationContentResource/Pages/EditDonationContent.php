<?php

namespace App\Filament\Resources\DonationContentResource\Pages;

use App\Filament\Resources\DonationContentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDonationContent extends EditRecord
{
    protected static string $resource = DonationContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
