<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Stokmasuk;
use App\Observers\StokMasukObserver;

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
        Stokmasuk::observe(StokMasukObserver::class);
    }
}
