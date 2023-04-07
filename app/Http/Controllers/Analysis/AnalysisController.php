<?php

namespace App\Http\Controllers\Analysis;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Contracts\Services\Analysis\AnalysisServiceContract;

class AnalysisController extends Controller
{
    public function __construct(private AnalysisServiceContract $analysisService) {}

    public function analyze(Request $request): JsonResponse
    {
        $data = $request->all();

        $result = $this->analysisService->analyze($data);

        return response()->json($result);
    }
}
