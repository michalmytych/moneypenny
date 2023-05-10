<?php

namespace App\Http\Controllers\File;

use App\Models\File;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\File\FileService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Services\File\ProfileFileService;
use App\Services\File\TransactionFileService;
use App\Services\Import\ColumnMappingService;
use App\Services\Import\ImportSettingService;

class FileController extends Controller
{
    public function __construct(
        private readonly FileService            $fileService,
        private readonly ProfileFileService     $profileFileService,
        private readonly TransactionFileService $transactionFileService,
        private readonly ColumnMappingService   $columnMappingService,
        private readonly ImportSettingService   $importSettingService
    )
    {
    }

    public function index(): View
    {
        $files = $this->fileService->all();
        $importSettings = $this->importSettingService->all();
        $columnsMappings = $this->columnMappingService->all();

        return view('file.index', compact('files', 'importSettings', 'columnsMappings'));
    }

    public function show($id): View
    {
        return view('file.show', [
            'file' => $this->fileService->findOrFail($id),
        ]);
    }

    public function upload(Request $request): RedirectResponse
    {
        $fileType = $request->input('type');

        if ($fileType && $fileType === File::USER_AVATAR) {
            $request->validate([
                'file' => 'required'
            ]);

            $this->profileFileService->uploadAvatar(
                $request->file('file'),
                $request->user()->id
            );

            return redirect()->route('profile.edit');
        }

        $request->validate([
            'file' => 'required',
            'import_setting_id' => 'required|exists:import_settings,id',
            'columns_mapping_id' => 'required|exists:columns_mappings,id',
        ]);

        $this->transactionFileService->uploadTransactions(
            $request->file('file'),
            $request->input('import_setting_id'),
            $request->input('column_mapping_id'),
        );

        return redirect()->route('file.index');
    }
}
