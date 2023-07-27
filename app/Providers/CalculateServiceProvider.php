<?php

namespace App\Providers;

use App\Services\CalculateService;
use Illuminate\Support\ServiceProvider;

class CalculateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(CalculateService::class, function () {
            return new CalculateService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
