<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Import\Import;
use App\Observers\Auth\UserObserver;
use Illuminate\Auth\Events\Registered;
use App\Models\Transaction\Transaction;
use App\Observers\Import\ImportObserver;
use App\Observers\Transaction\TransactionObserver;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Import::observe(ImportObserver::class);
        Transaction::observe(TransactionObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
