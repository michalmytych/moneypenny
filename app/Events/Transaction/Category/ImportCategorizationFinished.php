<?php

namespace App\Events\Transaction\Category;

use Illuminate\Foundation\Events\Dispatchable;

class ImportCategorizationFinished
{
    use Dispatchable;

    public function __construct(public mixed $importId) {}
}
