<?php

namespace App\Filament\Widgets;

use DB;
use App\Models\UserProfile;
use Filament\Widgets\ChartWidget;

class AlumniChart extends ChartWidget
{
    protected static ?string $heading = 'Graduates each Year';
    protected int | string | array $columnSpan = 'full';
    protected function getData(): array
    {
        $graduatesPerYear = UserProfile::select('graduate_year', DB::raw('count(*) as total'))
            ->groupBy('graduate_year')
            ->orderBy('graduate_year') // Order by graduate year
            ->get();

        // Prepare the data for the chart
        $years = $graduatesPerYear->pluck('graduate_year')->toArray();
        $graduateCounts = $graduatesPerYear->pluck('total')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Number of Graduates',
                    'data' => $graduateCounts,  // Graduate counts for each year
                    'borderColor' => 'rgb(75, 192, 192)',
                    'fill' => false,
                    'data' => [100, 200, 300, 400, 500, 600, 700, 800, 900, 1000, 1500,]

                ],
            ],
            'labels' => $years,  // Graduate years
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
