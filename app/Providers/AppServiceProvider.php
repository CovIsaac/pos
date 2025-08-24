<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Subcategory;
use App\Observers\SubcategoryObserver;


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
        Subcategory::observe(SubcategoryObserver::class);
    }
}
