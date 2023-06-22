<?php

namespace App\Providers;

use ReflectionException;
use App\Mixins\FactoryMixin;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

class MixinServiceProvider extends ServiceProvider
{
    /**
     * @throws ReflectionException
     */
    public function boot(): void
    {
        Factory::mixin(new FactoryMixin);
    }
}
