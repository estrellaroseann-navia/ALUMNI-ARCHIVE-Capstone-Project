<?php

namespace App\Filament\Resources\App\Filament\WidgetsResource\Widgets;

use Filament\Widgets\Widget;

use App\Models\User;
use App\Models\Subject;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StudentDashboardWidget extends Widget
{
    public int $studentsCount;
    public int $subjectsCount;
    public $topStudents;


    protected static string $view = 'filament.widgets.student-dashboard-widget';
    public function mount(): void
    {

        $this->studentsCount = User::where('is_admin', 0)->count();


        $this->subjectsCount = Subject::count();


        $this->topStudents = User::with('userSubjects')->where('is_admin', 0)
            ->get()
            ->sortByDesc(function ($user) {
                $grades = $user->userSubjects->pluck('grade')->filter()->map(fn($grade) => (float) $grade);
                return $grades->avg();
            })
            ->take(10)
            ->map(function ($user) {
                $grades = $user->userSubjects->pluck('grade')->filter()->map(fn($grade) => (float) $grade);
                return [
                    'name' => $user->name,
                    'average' => round($grades->avg(), 2),
                ];
            });
    }

    public function getStats(): array
    {
        // Get the number of students
        $studentsCount = User::count();

        // Get the number of subjects
        $subjectsCount = Subject::count();

        // Get top 10 students with the highest average grade
        $topStudents = User::with('userSubjects')->where('is_admin', 0)
            ->get()
            ->sortByDesc(function ($user) {
                // Calculate the average grade
                $grades = $user->userSubjects->pluck('grade')->filter()->map(fn($grade) => (float) $grade);
                return $grades->avg();
            })
            ->take(10)
            ->map(function ($user) {
                // Calculate the average grade for each user
                $grades = $user->userSubjects->pluck('grade')->filter()->map(fn($grade) => (float) $grade);
                return [
                    'name' => $user->name,
                    'average' => round($grades->avg(), 2),
                ];
            });

        // Calculate the top 10 average grade (optional)
        $topAverage = $topStudents->pluck('average')->avg();

        // Return the Stats as cards
        return [
            // Stat for Number of Students
            Stat::make('Number of Students', $studentsCount)
                ->description('Total number of students')
                ->color('primary'),

            // Stat for Number of Subjects
            Stat::make('Number of Subjects', $subjectsCount)
                ->description('Total number of subjects')
                ->color('secondary'),

            // Stat for Top 10 Students Average
            Stat::make('Top 10 Students Average Grade', round($topAverage, 2))
                ->description('Average grade of the top 10 students')
                ->color('success'),
        ];
    }
}
