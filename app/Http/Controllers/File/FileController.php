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
use App\Services\Import\ImportService;

class FileController extends Controller
{
    public function __construct(private ImportService $importService) { }

    public function index(): View
    {
        $files          = File::latest()->get();
        $importSettings = ImportSetting::latest()->get();
        return view('file.index', compact('files', 'importSettings'));
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
        $request->validate([
            'file'              => 'required',
            'import_setting_id' => 'required|exists:import_settings,id',
        ]);

        $file = $request->file('file');

        $extension       = $file->getClientOriginalExtension();
        $timestamp       = time();
        $uuid            = Str::uuid();
        $importSettingId = $request->input('import_setting_id');

        $fileName = "upload_{$uuid}_{$timestamp}.{$extension}";

        $fileModel = new File();

        $fileModel->name              = $file->getClientOriginalName();
        $fileModel->path              = "uploads/{$fileName}";
        $fileModel->size              = $file->getSize();
        $fileModel->import_setting_id = $importSettingId;

        DB::transaction(function () use ($fileModel, $file, $fileName) {
            $fileModel->save();
            $file->storeAs('uploads', $fileName);
        });

        $this->importService->importFromFile($fileModel->path, $importSettingId);

        return redirect()->route('file.index');
    }
}
