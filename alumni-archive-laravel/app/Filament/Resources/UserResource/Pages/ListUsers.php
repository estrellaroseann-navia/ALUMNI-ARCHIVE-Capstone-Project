<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use App\Imports\UsersImport;
use Filament\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Filament\Resources\UserResource;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;


class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->icon('heroicon-o-plus'),
            Action::make('importAlumni')->label('Import Alumni')->icon('heroicon-o-document')->button()->form([
                FileUpload::make('file')->disk('public'), // Ensure it uses the 'public' disk
            ])->action(function (array $data) {
                // Get the file's storage path
                $filePath = Storage::disk('public')->path($data['file']);

                if (!file_exists($filePath)) {
                    Notification::make()
                        ->title('File not found')
                        ->danger()
                        ->send();
                    return;
                }

                Excel::import(new UsersImport, $filePath);

                Notification::make()
                    ->title('Imported Successfully')
                    ->success()
                    ->send();
            })
        ];
    }
}
