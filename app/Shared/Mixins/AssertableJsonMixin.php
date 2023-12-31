<?php

namespace App\Shared\Mixins;

use Closure;
use Illuminate\Testing\Fluent\AssertableJson;

class AssertableJsonMixin
{
    public function hasValidPagination(): Closure
    {
        return function (): AssertableJson {
            /** @var AssertableJson $this */
            return $this
                ->whereType('data', 'array')
                ->whereType('current_page', 'integer')
                ->whereType('first_page_url', 'string')
                ->whereType('from', ['integer', 'null'])
                ->whereType('last_page', 'integer')
                ->whereType('last_page_url', 'string')
                ->whereType('links', 'array')
                ->whereType('next_page_url', ['string', 'null'])
                ->whereType('path', 'string')
                ->whereType('prev_page_url', ['string', 'null'])
                ->whereType('to', 'integer')
                ->whereType('per_page', 'integer')
                ->whereType('total', 'integer');
        };
    }
}
