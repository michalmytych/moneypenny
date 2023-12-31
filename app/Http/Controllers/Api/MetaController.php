<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Shared\Services\Meta\MetaService;
use Illuminate\Http\JsonResponse;

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
