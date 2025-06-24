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

    public function updateSystem(): JsonResponse
    {
        try {
            $results = $this->metaService->updateSystem();
        } catch (\Throwable $throwable) {
            return response()->json([
                '__exec_meta' => [
                    'target_host' => gethostbyname(config('admin-ssh.host')),
                    'on_host' => $this->metaService->getLocalIp(),
                ],
                'error' => [
                    'exception_message' => $throwable->getMessage(),
                    'exception_file' => $throwable->getFile(),
                    'exception_line' => $throwable->getLine(),
                ],
            ], 500);
        }

        return response()->json($results);
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
