<?php

namespace App\Shared\Providers;

use App\Shared\Mixins\AssertableJsonMixin;
use App\Shared\Mixins\FactoryMixin;
use App\Shared\Mixins\RouteMixin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Testing\Fluent\AssertableJson;
use ReflectionException;

class MixinServiceProvider extends ServiceProvider
{
    /**
     * @throws ReflectionException
     */
    public function boot(): void
    {
        Factory::mixin(new FactoryMixin);
        AssertableJson::mixin(new AssertableJsonMixin());
        Route::mixin(new RouteMixin());
    }
}
