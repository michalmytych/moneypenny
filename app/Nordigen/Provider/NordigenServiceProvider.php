<?php

namespace App\Nordigen\Provider;

use App\Nordigen\NordigenClient;
use Illuminate\Support\ServiceProvider;

class NordigenServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(NordigenClient::class, function ($app) {
            return new NordigenClient([
                'base_uri' => $app->config->get('nordigen.base_uri'),
                'headers'  => $app->config->get('nordigen.headers'),
            ]);
        });
    }
}
