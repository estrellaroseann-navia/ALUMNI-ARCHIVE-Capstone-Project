<?php

namespace App\Filament\Resources\DonationContentResource\Pages;

use App\Filament\Resources\DonationContentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDonationContents extends ListRecords
{
    protected static string $resource = DonationContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
