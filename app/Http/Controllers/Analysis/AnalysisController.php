<?php

namespace App\Http\Controllers\Analysis;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Contracts\Services\Analysis\AnalysisServiceContract;

class AnalysisController extends Controller
{
    public function __construct(private readonly AnalysisServiceContract $analysisService)
    {
    }

    public function analyze(Request $request): JsonResponse
    {
        $result = $this->analysisService->analyze($request->all());
        return response()->json($result);
    }
}
