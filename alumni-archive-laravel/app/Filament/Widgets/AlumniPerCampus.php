<?php

namespace App\Filament\Widgets;

use App\Models\UserProfile;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class AlumniPerCampus extends ChartWidget
{
    protected static ?string $heading = 'Graduates Per Campus';
    protected static ?int $sort = 2;

    function generateColorFromString($string)
    {
        $hash = md5($string); // Generate a hash from the string
        $red = hexdec(substr($hash, 0, 2)) % 256;
        $green = hexdec(substr($hash, 2, 2)) % 256;
        $blue = hexdec(substr($hash, 4, 2)) % 256;

        return "rgb($red, $green, $blue)";
    }

    protected function getData(): array
    {
        // Query the number of graduates per campus
        $graduatesPerCampus = UserProfile::select('campus_id', \DB::raw('count(*) as total'))
            ->groupBy('campus_id')  // Group by campus_id
            ->orderBy('campus_id')  // Order by campus_id or by name if desired
            ->get();

        // Prepare the data for the chart
        $campuses = $graduatesPerCampus->pluck('campus.name')->toArray();  // Get campus names
        $graduateCounts = $graduatesPerCampus->pluck('total')->toArray();  // Get the graduate counts
        $colors = [];
        foreach ($graduateCounts as $program) {
            $colors[] = $this->generateColorFromString($program);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Number of Graduates',
                    'data' => $graduateCounts,  // Graduate counts for each campus
                    'borderColor' => 'rgb(75, 192, 192)',
                    'fill' => false,
                    'backgroundColor' => $colors
                ],
            ],
            'labels' => $campuses,  // Labels as campus names
        ];
    }
    protected function getType(): string
    {
        return 'doughnut';
    }
}
