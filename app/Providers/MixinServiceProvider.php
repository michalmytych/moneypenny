<?php

namespace App\Providers;

use App\Mixins\RouteMixin;
use ReflectionException;
use App\Mixins\FactoryMixin;
use App\Mixins\AssertableJsonMixin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Database\Eloquent\Factories\Factory;

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
