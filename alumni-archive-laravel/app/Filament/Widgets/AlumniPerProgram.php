<?php

namespace App\Filament\Widgets;

use App\Models\UserProfile;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class AlumniPerProgram extends ChartWidget
{
    protected static ?string $heading = 'Graduates Per Program';
    protected static ?int $sort = 4;
    protected function getData(): array
    {
        // Query the number of graduates per program
        $graduatesPerProgram = UserProfile::select('program_id', \DB::raw('count(*) as total'))
            ->groupBy('program_id')  // Group by program_id
            ->orderBy('program_id')  // Order by program_id or by name if desired
            ->get();

        // Prepare the data for the chart
        $programs = $graduatesPerProgram->pluck('program.name')->toArray();  // Get program names
        $graduateCounts = $graduatesPerProgram->pluck('total')->toArray();  // Get the graduate counts

        return [
            'datasets' => [
                [
                    'label' => 'Number of Graduates',
                    'data' => $graduateCounts,  // Graduate counts for each program
                    'borderColor' => 'rgb(75, 192, 192)',
                    'fill' => false,
                ],
            ],
            'labels' => $programs,  // Labels as program names
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
