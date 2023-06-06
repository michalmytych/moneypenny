<?php

namespace App\Http\Controllers\Web\Debug;

use App\Http\Controllers\Controller;
use App\Services\Analytics\AnalyzerResolver;
use Illuminate\View\View;

class DebugController extends Controller
{
    public function __construct(private readonly AnalyzerResolver $analyzerResolver) {}

    public function analyzers(): View
    {
        $analyzersMapping = $this->analyzerResolver->getEnabledAnalyzersMapping();
        $analyzers = $analyzersMapping->keys();
        return view('debug.analyzers', compact('analyzers'));
    }
}
