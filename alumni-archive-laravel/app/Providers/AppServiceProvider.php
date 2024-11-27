<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\EnsureStudentIsAuthenticated;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app['router']->aliasMiddleware('student', EnsureStudentIsAuthenticated::class);
    }
}
