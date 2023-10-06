<?php

namespace App\Mixins;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

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
