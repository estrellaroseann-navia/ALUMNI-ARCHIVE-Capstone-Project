<?php

namespace App\Filament\Resources\ClusterResource\Pages;

use App\Filament\Resources\ClusterResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCluster extends CreateRecord
{
    protected static string $resource = ClusterResource::class;


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
