<?php

namespace App\Providers;

use App\Models\Reservations;
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
        view()->share('receivedCount',
            Reservations::where('res_status', 'Received')->count());
    }
}
