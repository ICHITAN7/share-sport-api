<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Support\ServiceProvider;

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
        $user = auth()->user();
        print $user;
        Table::configureUsing(function (table $table) {
            return $table
                ->filtersLayout(FiltersLayout::Modal)
                ->deferLoading()
                ->striped();
        });
    }
}
