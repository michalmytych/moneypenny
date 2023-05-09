<?php

namespace App\Http\Controllers\File;

use App\Models\File;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Import\ImportSetting;
use Illuminate\Http\RedirectResponse;
use App\Models\Import\ColumnsMapping;
use App\Services\Import\ImportService;

class FileController extends Controller
{
    public function __construct(private readonly ImportService $importService)
    {
    }

    public function index(): View
    {
        $files = File::latest()->get();
        $importSettings = ImportSetting::latest()->get();
        $columnsMappings = ColumnsMapping::latest()->get();
        return view('file.index', compact('files', 'importSettings', 'columnsMappings'));
    }

    public function show($id): View
    {
        $file = File::findOrFail($id);

        return view('file.show', [
            'file' => $file,
        ]);
    }

    public function upload(Request $request): RedirectResponse
    {
        $fileType = $request->input('type');

        if ($fileType) {
            if ($fileType === File::USER_AVATAR) {
                return $this->uploadAvatar($request);
            }
        }

        return $this->uploadTransactions($request);
    }

    private function uploadTransactions(Request $request): RedirectResponse
    {
        $file = $request->file('file');

        $request->validate([
            'file' => 'required',
            'import_setting_id' => 'required|exists:import_settings,id',
            'columns_mapping_id' => 'required|exists:columns_mappings,id',
        ]);

        $extension = $file->getClientOriginalExtension();
        $timestamp = time();
        $uuid = Str::uuid();
        $importSettingId = $request->input('import_setting_id');
        $columnMappingId = $request->input('columns_mapping_id');

        $fileName = "upload_{$uuid}_{$timestamp}.{$extension}";

        $fileModel = new File();
        $fileModel->name = $file->getClientOriginalName();
        $fileModel->path = "uploads/{$fileName}";
        $fileModel->size = $file->getSize();
        $fileModel->import_setting_id = $importSettingId;

        $this->registerAndStoreFile($fileModel, $file, $fileName);

        $this->importService->importFromFile($fileModel->id, $importSettingId, $columnMappingId);

        return redirect()->route('file.index');
    }

    private function uploadAvatar(Request $request): RedirectResponse
    {
        $file = $request->file('file');

        $request->validate([
            'file' => 'required'
        ]);

        $extension = $file->getClientOriginalExtension();
        $fileName = $request->user()?->id . '_avatar.' . $extension;

        $file->storePubliclyAs('public/avatars/', $fileName);

        return redirect()->route('profile.edit');
    }

    private function registerAndStoreFile(File $fileModel, $fileObj, string $fileName): void
    {
        DB::transaction(function () use ($fileModel, $fileObj, $fileName) {
            $fileModel->save();
            $fileObj->storeAs('uploads', $fileName);
        });
    }
}
