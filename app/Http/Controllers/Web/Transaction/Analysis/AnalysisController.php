<?php

namespace App\Http\Controllers\Web\Transaction\Analysis;

use App\Contracts\Services\Analysis\AnalysisServiceContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @deprecated
 */
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
