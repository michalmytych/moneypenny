<?php

namespace App\Jobs\Auth;

use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Models\Auth\Settings;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateUserSettings implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public User $user) {}

    public function handle(): void
    {
        // @todo - move to service
        Settings::firstOrCreate([
            'user_id' => $this->user->id,
            'base_currency_code' => config('moneypenny.base_calculation_currency')
        ]);
    }
}
