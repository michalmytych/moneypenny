<?php

namespace App\Http\Controllers\Web\Debug;

use App\Http\Controllers\Controller;

/**
 * @deprecated
 */
class DebugController extends Controller
{
    public function analyzers(): string
    {
        return 'deprecated';
    }
}
