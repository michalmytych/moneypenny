<?php

namespace App\Http\Controllers\Web\File;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\File\FileUploadRequest;
use App\Models\File;
use App\Services\File\FileService;
use App\Services\File\FileUploadService;
use App\Services\File\ProfileFileService;
use App\Services\File\TransactionFileService;
use App\Services\Import\ColumnMappingService;
use App\Services\Import\ImportSettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Throwable;

class FileController extends Controller
{
    public function __construct(
        private readonly FileService            $fileService,
        private readonly FileUploadService      $fileUploadService,
        private readonly ColumnMappingService   $columnMappingService,
        private readonly ImportSettingService   $importSettingService
    )
    {
    }

    public function index(Request $request): View
    {
        $user = $request->user();
        $files = $this->fileService->all($user);
        $importSettings = $this->importSettingService->all($user);
        $columnsMappings = $this->columnMappingService->all($user);

        return view('file.index', compact('files', 'importSettings', 'columnsMappings'));
    }

    public function show(mixed $id, Request $request): View
    {

        return view('file.show', [
            'file' => $this->fileService->findOrFail($id, $request->user()),
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function upload(FileUploadRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user = $request->user();
        $file = $request->file('file');

        $this->fileUploadService->upload($user, $file, $data);

        return redirect()->back();
    }
}
