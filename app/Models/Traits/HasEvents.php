<?php

namespace App\Models\Traits;

use App\Models\Statistics\Event;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @method morhpMany(string $class, string $string)
 */
trait HasEvents
{
    /**
     * @return MorphMany
     */
    public function eventable(): MorphMany
    {
        return $this->morhpMany(Event::class, 'eventable');
    }
}
