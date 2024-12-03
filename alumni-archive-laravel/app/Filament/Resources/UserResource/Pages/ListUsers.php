<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use App\Models\Campus;
use App\Models\Program;
use App\Models\UserProfile;
use App\Imports\UsersImport;
use Filament\Actions\Action;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Facades\Storage;
use App\Exports\UserProfileReportExport;
use App\Filament\Resources\UserResource;
use Filament\Forms\Components\TextInput;
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
            Action::make('importAlumni')->label('Import Alumni')->icon('heroicon-o-document-plus')->button()->form([
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
            }),
            Action::make('generateReport')
                ->label('Generate Report')
                ->icon('heroicon-o-document-arrow-down')
                ->button()
                ->form([
                    Select::make('campus_id')
                        ->label('Campus')
                        ->options(Campus::pluck('name', 'id'))
                        ->placeholder('Select a campus'),

                    Select::make('program_id')
                        ->label('Program')
                        ->options(Program::pluck('name', 'id'))
                        ->placeholder('Select a program'),

                    TextInput::make('graduate_year')
                        ->label('Graduate Year')
                        ->placeholder('Enter Graduate Year'),

                    Toggle::make('export_all')
                        ->label('Export All')
                        ->helperText('Export all data regardless of filters.')
                        ->default(false),
                ])
                ->action(function (array $data) {
                    $query = UserProfile::query();

                    // Apply filters only if 'export_all' is false
                    if (empty($data['export_all'])) {
                        if (!empty($data['campus_id'])) {
                            $query->where('campus_id', $data['campus_id']);
                        }

                        if (!empty($data['program_id'])) {
                            $query->where('program_id', $data['program_id']);
                        }

                        if (!empty($data['graduate_year'])) {
                            $query->where('graduate_year', $data['graduate_year']);
                        }
                    }

                    // Fetch data for export
                    $profiles = $query->with(['campus', 'program'])
                        ->get(['last_name', 'first_name', 'middle_name', 'complete_address', 'campus_id', 'program_id']);

                    // Prepare data for Excel export
                    $formattedData = $profiles->map(function ($profile) {
                        return [
                            'Last Name' => $profile->last_name,
                            'First Name' => $profile->first_name,
                            'Middle Name' => $profile->middle_name,
                            'Address' => $profile->complete_address,
                            'Campus' => $profile->campus->name ?? 'N/A',
                            'Program' => $profile->program->name ?? 'N/A',
                        ];
                    });

                    // Export the data as an Excel file
                    return Excel::download(new UserProfileReportExport($formattedData), 'alumni_list.xlsx');

                    Notification::make()
                        ->title('Generated Successfully')
                        ->success()
                        ->send();
                })


        ];
    }
}
