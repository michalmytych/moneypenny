<?php

namespace App\Shared\Mixins;

use Closure;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Model $model
 */
class FactoryMixin
{
    /** @noinspection PhpUndefinedMethodInspection */
    public function firstOrCreate(): Closure
    {
        return function (): Model {
            /** @var Factory $this */
            return $this->modelName()::first() ?? $this->modelName()::factory()->create();
        };
    }
}
