<?php

namespace App\Http\Controllers\Web\File;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Services\File\FileService;
use App\Services\File\ProfileFileService;
use App\Services\File\TransactionFileService;
use App\Services\Import\ColumnMappingService;
use App\Services\Import\ImportSettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
        $user = $request->user();
        return view('file.show', [
            'file' => $this->fileService->findOrFail($id, $user),
        ]);
    }

    public function upload(Request $request): RedirectResponse
    {
        $user = $request->user();
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
            $request->input('columns_mapping_id'),
            $user
        );

        return redirect()->route('file.index');
    }
}
