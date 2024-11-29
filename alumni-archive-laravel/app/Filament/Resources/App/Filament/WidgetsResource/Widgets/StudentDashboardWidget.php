<?php

namespace App\Filament\Resources\App\Filament\WidgetsResource\Widgets;

use Filament\Widgets\Widget;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Program;
use App\Models\Campus;
use Illuminate\View\View;
use Filament\Forms\Components\Select;

class StudentDashboardWidget extends Widget
{
    public int $alumniCount;
    public ?string $program = null;
    public ?string $campus = null;
    public ?string $cluster = null;
    public ?int $graduateYear = null;

    protected static string $view = 'filament.widgets.student-dashboard-widget';

    public function mount(): void
    {
        $query = User::where('is_admin', 0);

        // Apply filters based on form selection
        if ($this->program) {
            $query->whereHas('userProfile.program', function ($query) {
                $query->where('name', $this->program); // Assuming 'name' is the column in 'programs'
            });
        }

        if ($this->campus) {
            $query->whereHas('userProfile.campus', function ($query) {
                $query->where('name', $this->campus); // Assuming 'name' is the column in 'campuses'
            });
        }

        if ($this->graduateYear) {
            $query->whereHas('userProfile', function ($query) {
                $query->where('graduate_year', $this->graduateYear);
            });
        }

        $this->alumniCount = $query->count();
    }

    public function render(): View
    {
        // Data for graphs
        $graduateYears = UserProfile::select('graduate_year', \DB::raw('count(*) as total'))
            ->groupBy('graduate_year')
            ->orderBy('graduate_year')
            ->get();

        $programs = UserProfile::select('program_id', \DB::raw('count(*) as total'))
            ->groupBy('program_id')
            ->with('program') // Include the program name
            ->get();

        return view(self::$view, [
            'alumniCount' => $this->alumniCount,
            'programs' => Program::pluck('name', 'id'),
            'campuses' => Campus::pluck('name', 'id'),
            'graduateYears' => UserProfile::distinct()->pluck('graduate_year'),
            'graduateYearsData' => $graduateYears, // Data for line graph
            'programsData' => $programs, // Data for pie chart
        ]);
    }

    public function getFormSchema(): array
    {
        return [
            Select::make('program')
                ->label('Program')
                ->options(Program::pluck('name', 'id'))
                ->placeholder('Select Program')
                ->reactive()
                ->afterStateUpdated(fn() => $this->mount()),

            Select::make('campus')
                ->label('Campus')
                ->options(Campus::pluck('name', 'id'))
                ->placeholder('Select Campus')
                ->reactive()
                ->afterStateUpdated(fn() => $this->mount()),

            Select::make('graduateYear')
                ->label('Graduate Year')
                ->options(UserProfile::distinct()->pluck('graduate_year', 'graduate_year'))
                ->placeholder('Select Graduate Year')
                ->reactive()
                ->afterStateUpdated(fn() => $this->mount()),
        ];
    }
}
