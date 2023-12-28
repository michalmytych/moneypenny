<?php

namespace App\Mixins;

use Closure;
use Illuminate\Support\Facades\Route;

class RouteMixin
{
    public function crud(): Closure
    {
        return function (
            array  $groupConfig,
            ?string $index = null,
            ?string $show = null,
            ?string $create = null,
            ?string $update = null,
            ?string $delete = null
        ) {
            /** @var Route $this */
            if ($index) $this->get('/', [$index, 'index']);
            if ($show) $this->get('/{id}', [$show, 'show']);
            if ($create) $this->post('/', [$create, 'create']);
            if ($update) $this->put('/{id}', [$update, 'update']);
            if ($delete) $this->delete('/{id}', [$delete, 'delete']);

            return $this;
        };
    }
}
