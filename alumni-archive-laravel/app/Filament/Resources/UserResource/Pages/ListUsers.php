<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use App\Imports\UsersImport;
use Filament\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use App\Filament\Resources\UserResource;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;


class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->icon('heroicon-o-plus'),
            Action::make('importAlumni')->label('Import Alumni')->icon('heroicon-o-document')->button()->form([
                FileUpload::make('file')
            ])->action(function (array $data) {
                $file = public_path('storage/' . $data['file']);
                Excel::import(new UsersImport, $file);

                Notification::make()->title('Imported Successfully')->success()->send();
            })
        ];
    }
}
