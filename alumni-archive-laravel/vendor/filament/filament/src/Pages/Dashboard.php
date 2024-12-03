<?php

namespace Filament\Pages;

use App\Models\Campus;
use App\Models\Cluster;
use App\Models\Program;
use App\Models\UserProfile;
use Filament\Actions\Action;
use Filament\Widgets\Widget;
use Maatwebsite\Excel\Excel;
use Filament\Facades\Filament;
use App\Exports\DashboardReport;
use App\Filament\Widgets\AlumniChart;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use App\Exports\UserProfileReportExport;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use App\Filament\Widgets\AlumniPerCampus;
use Filament\Widgets\WidgetConfiguration;
use App\Filament\Widgets\AlumniPerProgram;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Contracts\Support\Htmlable;
use PHPUnit\Framework\MockObject\Builder\Stub;
use App\Filament\Resources\App\Filament\WidgetsResource\Widgets\StudentDashboardWidget;

class Dashboard extends Page
{
    protected static string $routePath = '/';

    protected static ?int $navigationSort = -2;

    /**
     * @var view-string
     */
    protected static string $view = 'filament-panels::pages.dashboard';

    public static function getNavigationLabel(): string
    {
        return static::$navigationLabel ??
            static::$title ??
            __('filament-panels::pages/dashboard.title');
    }

    protected function getActions(): array
    {
        return [
            Action::make('generateReport')
                ->label('Generate Report')
                ->icon('heroicon-o-document-arrow-down')
                ->button()
                ->form([
                    Select::make('cluster_ids')  // Multi-select clusters
                        ->label('Clusters')
                        ->options(Cluster::pluck('name', 'id'))  // Assuming Cluster model exists
                        ->multiple()
                        ->placeholder('Select clusters'),

                    Select::make('campus_ids')  // Multi-select campuses
                        ->label('Campuses')
                        ->options(Campus::pluck('name', 'id'))
                        ->multiple()
                        ->placeholder('Select campuses'),

                    Select::make('program_ids')  // Multi-select programs
                        ->label('Programs')
                        ->options(Program::pluck('name', 'id'))
                        ->multiple()
                        ->placeholder('Select programs'),
                    Select::make('graduate_year')  // Graduate year filter
                        ->label('Graduate Year')
                        ->multiple()
                        ->options(array_combine(range(2019, now()->year), range(2019, now()->year)))
                        ->placeholder('Select Graduate Year'),


                    // Toggle::make('export_all')  // Export All toggle
                    //     ->label('Export All')
                    //     ->helperText('Export all data regardless of filters.')
                    //     ->default(false),
                ])
                ->action(function (array $data) {
                    $query = UserProfile::query();

                    // Apply filters only if 'export_all' is false
                    if (empty($data['export_all'])) {
                        if (!empty($data['cluster_ids'])) {
                            // Join the campuses and filter by clusters
                            $query->whereIn('campus_id', $data['campus_ids']);  // Campus filter
                            $query->whereHas('campus.cluster', function ($subQuery) use ($data) {
                                $subQuery->whereIn('id', $data['cluster_ids']);  // Filter clusters
                            });
                        }

                        if (!empty($data['campus_ids'])) {
                            $query->whereIn('campus_id', $data['campus_ids']);
                        }

                        if (!empty($data['program_ids'])) {
                            $query->whereIn('program_id', $data['program_ids']);
                        }

                        if (!empty($data['graduate_year'])) {
                            $query->where('graduate_year', $data['graduate_year']);
                        }
                    }

                    // Fetch the count of alumni per campus, program, and cluster
                    $counts = $query->with(['campus', 'program'])  // Eager load campus and program relationships
                        ->select('campus_id', 'program_id', \DB::raw('count(*) as total'))
                        ->groupBy('campus_id', 'program_id')  // Group by campus and program
                        ->get();

                    // Prepare the data for each cluster
                    $clusterData = [];

                    foreach ($data['cluster_ids'] as $clusterId) {
                        $clusterData[$clusterId] = $counts->filter(function ($count) use ($clusterId) {
                            // Filter data based on the cluster ID
                            return $count->campus->cluster_id == $clusterId;
                        })->map(function ($count) {
                            return [
                                'Campus' => $count->campus->name ?? 'N/A',
                                'Program' => $count->program->name ?? 'N/A',
                                'Total Alumni Count' => $count->total,
                            ];
                        });
                    }

                    // Generate the Excel report with multiple sheets for each cluster
                    return app(Excel::class)->download(new DashboardReport($clusterData), 'report.xlsx');


                    // Show success notification
                    Notification::make()
                        ->title('Report Generated Successfully')
                        ->success()
                        ->send();
                })

        ];
    }

    public static function getNavigationIcon(): string | Htmlable | null
    {
        return static::$navigationIcon
            ?? FilamentIcon::resolve('panels::pages.dashboard.navigation-item')
            ?? (Filament::hasTopNavigation() ? 'heroicon-m-home' : 'heroicon-o-home');
    }

    public static function getRoutePath(): string
    {
        return static::$routePath;
    }

    /**
     * @return array<class-string<Widget> | WidgetConfiguration>
     */
    public function getWidgets(): array
    {
        // return Filament::getWidgets();
        return [
            // StudentDashboardWidget::class,
            AlumniChart::class,
            AlumniPerCampus::class,
            AlumniPerProgram::class,
        ];
    }

    /**
     * @return array<class-string<Widget> | WidgetConfiguration>
     */
    public function getVisibleWidgets(): array
    {
        return $this->filterVisibleWidgets($this->getWidgets());
    }

    /**
     * @return int | string | array<string, int | string | null>
     */
    public function getColumns(): int | string | array
    {
        return 2;
    }

    public function getTitle(): string | Htmlable
    {
        return static::$title ?? __('filament-panels::pages/dashboard.title');
    }
}
