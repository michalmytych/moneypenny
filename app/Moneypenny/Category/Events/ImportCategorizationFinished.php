<?php

namespace App\Moneypenny\Category\Events;

use Illuminate\Foundation\Events\Dispatchable;

class ImportCategorizationFinished
{
    use Dispatchable;

    public function __construct(public mixed $importId) {}
}
