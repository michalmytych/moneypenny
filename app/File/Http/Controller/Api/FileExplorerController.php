<?php

namespace App\File\Http\Controller\Api;

use App\Shared\Http\Controller\Controller;
use App\Shared\Services\FileExplorer\DirectoryRenderBuilder;
use App\Shared\Services\FileExplorer\FileRenderBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FileExplorerController extends Controller
{
    public function __construct(
        private readonly FileRenderBuilder $fileRenderBuilder,
        private readonly DirectoryRenderBuilder $directoryRenderBuilder
    ) {}

    public function get(Request $request): StreamedResponse
    {
        $fileStoragePath = $request->get('path');
        return Storage::download($fileStoragePath);
    }

    public function show(Request $request): JsonResponse
    {
        $storagePath = $request->get('path');

        try {
            $fileRender = $this
                ->fileRenderBuilder
                ->setStoragePath($storagePath)
                ->build();

        } catch (NotFoundHttpException $exception) {
            return response()->json([
                'exists' => false,
                'message' => $exception->getMessage(),
            ], 404);
        }

        return response()->json([
            'exists' => true,
            'file_type' => $fileRender->getFileType(),
            'render' => $fileRender->getRenderedFile()
        ]);
    }

    public function open(Request $request): JsonResponse
    {
        $targetPath = $request->get('path');

        $directoryRender = $this
            ->directoryRenderBuilder
            ->setTargetPath($targetPath)
            ->build();

        return response()->json([
            'requested_path' => $targetPath,
            'render' => $directoryRender->getRenderedDirectory()
        ]);
    }
}
