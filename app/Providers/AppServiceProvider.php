<?php

namespace App\Providers;

use App\Services\SSH\SshService;
use App\Services\Import\ImportService;
use Illuminate\Support\ServiceProvider;
use App\Services\Nordigen\NordigenService;
use App\Contracts\Services\Import\ImportServiceContract;
use App\Contracts\Services\Transaction\TransactionSyncServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ImportServiceContract::class, ImportService::class);
        $this->app->bind(TransactionSyncServiceInterface::class, NordigenService::class);

        $this->app->singleton(SshService::class, function ($app) {
            return new SshService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('viewPulse', function (User $user) {
            return $user->isAdmin();
        });
    }
}
