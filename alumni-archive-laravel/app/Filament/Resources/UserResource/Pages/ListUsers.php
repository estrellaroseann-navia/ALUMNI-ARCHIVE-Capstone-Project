<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use App\Models\UserProfile;
use App\Imports\UsersImport;
use Filament\Actions\Action;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Exports\UserProfileReportExport;
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
            Action::make('generateReport')->label('Generate Report')->icon('heroicon-o-document-arrow-down')->button()->action(function (array $data) {
                $graduateYearCounts = UserProfile::select('graduate_year', DB::raw('COUNT(*) as total'))
                    ->groupBy('graduate_year')
                    ->get();

                $campusCounts = UserProfile::with('campus')
                    ->select('campus_id', DB::raw('COUNT(*) as total'))
                    ->groupBy('campus_id')
                    ->get();

                $programCounts = UserProfile::with('program')
                    ->select('program_id', DB::raw('COUNT(*) as total'))
                    ->groupBy('program_id')
                    ->get();

                $data = [
                    'graduate_years' => $graduateYearCounts,
                    'campuses' => $campusCounts,
                    'programs' => $programCounts,
                ];

                return Excel::download(new UserProfileReportExport($data), 'user_profile_report.xlsx');

                Notification::make()
                    ->title('Generated Successfully')
                    ->success()
                    ->send();
            })
        ];
    }
}
