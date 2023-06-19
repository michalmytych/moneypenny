<?php

namespace App\Http\Controllers\Web\FileExplorer;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Services\FileExplorer\FileRenderBuilder;
use App\Services\FileExplorer\DirectoryRenderBuilder;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FileExplorerController extends Controller
{
    public function __construct(
        private readonly FileRenderBuilder $fileRenderBuilder,
        private readonly DirectoryRenderBuilder $directoryRenderBuilder
    ) {}

    public function index(): View
    {
        return view('file_explorer.index');
    }

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
