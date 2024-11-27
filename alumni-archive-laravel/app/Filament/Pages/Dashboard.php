<?php

namespace App\Filament\Pages;

use App\Filament\Resources\App\Filament\WidgetsResource\Widgets\StudentDashboardWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static string $view = 'filament.pages.dashboard';

    public function getWidgets(): array
    {
        return [
            StudentDashboardWidget::class,
        ];
    }
}
