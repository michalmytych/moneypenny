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
        return response()->json($this->metaService->getTopProcesses());
    }
}
