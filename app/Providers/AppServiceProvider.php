<?php

namespace App\Providers;

use App\Services\Import\ImportService;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Services\Import\ImportServiceContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ImportServiceContract::class, ImportService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
