<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Services\Meta\MetaService;
use App\Http\Controllers\Controller;

class MetaController extends Controller
{
    public function __construct(private readonly MetaService $metaService)
    {
    }

    public function processes(): JsonResponse
    {
        $serverTopProcesses = $this->metaService->getTopProcesses();
        return response()->json($serverTopProcesses);
    }

    public function jobs(): JsonResponse
    {
        $jobs = $this->metaService->getJobsList();
        return response()->json($jobs);
    }
}
