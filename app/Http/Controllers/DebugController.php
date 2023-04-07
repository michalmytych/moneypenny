<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Collection;
use App\Services\Analysis\AnalyzerResolver;

class DebugController extends Controller
{
    public function analyzers(): View
    {
        /** @var Collection $analyzersMapping */
        $analyzersMapping = app(AnalyzerResolver::class)->getEnabledAnalyzersMapping();
        $analyzers        = $analyzersMapping->keys();
        return view('debug.analyzers', compact('analyzers'));
    }
}
