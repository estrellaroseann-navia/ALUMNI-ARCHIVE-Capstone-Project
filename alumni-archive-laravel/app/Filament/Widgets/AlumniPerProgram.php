<?php

namespace App\Filament\Widgets;

use App\Models\UserProfile;
use Filament\Widgets\ChartWidget;
use Filament\Forms;

class AlumniPerProgram extends ChartWidget
{
    protected static ?string $heading = 'Graduates Per Program';
    protected static ?int $sort = 4;

    public ?string $graduateYear = null; // Property to store the selected year

    function generateColorFromString($string)
    {
        $hash = md5($string); // Generate a hash from the string
        $red = hexdec(substr($hash, 0, 2)) % 256;
        $green = hexdec(substr($hash, 2, 2)) % 256;
        $blue = hexdec(substr($hash, 4, 2)) % 256;

        return "rgb($red, $green, $blue)";
    }

    // Define the form schema for the filter
    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('graduateYear')
                ->label('Graduate Year')
                ->options(
                    UserProfile::select('graduate_year')
                        ->distinct()
                        ->orderBy('graduate_year')
                        ->pluck('graduate_year', 'graduate_year')
                        ->toArray()
                )
                ->placeholder('All Years')
                ->reactive() // Refresh widget when changed
                ->afterStateUpdated(fn($state) => $this->graduateYear = $state), // Update the filter state
        ];
    }

    // Generate chart data with filtering
    protected function getData(): array
    {
        $graduateYear = $this->graduateYear; // Use the selected filter value

        // Query graduates per program, applying the filter if set
        $graduatesPerProgram = UserProfile::select('program_id', \DB::raw('count(*) as total'))
            ->when($graduateYear, function ($query) use ($graduateYear) {
                $query->where('graduate_year', $graduateYear);
            })
            ->groupBy('program_id')
            ->orderBy('program_id')
            ->get();

        // Prepare chart data
        $programs = $graduatesPerProgram->pluck('program.name')->toArray();
        $graduateCounts = $graduatesPerProgram->pluck('total')->toArray();

        $colors = [];
        foreach ($programs as $program) {
            $colors[] = $this->generateColorFromString($program);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Number of Graduates',
                    'data' => $graduateCounts,
                    'borderColor' => 'rgb(75, 192, 192)',
                    'fill' => false,
                    'backgroundColor' => $colors,

                ],
            ],
            'labels' => $programs,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
