<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        Table::configureUsing(function (table $table) {
            return $table
                ->filtersLayout(FiltersLayout::Modal)
                ->deferLoading()
                ->striped();
        });
        if (env('APP_ENV') !== 'local') {
        URL::forceScheme('https');
    }
    }
}
