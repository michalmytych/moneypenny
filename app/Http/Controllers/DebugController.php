<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Services\Analysis\AnalyzerResolver;

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
