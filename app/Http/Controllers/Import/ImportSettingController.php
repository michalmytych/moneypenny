<?php

namespace App\Http\Controllers\Import;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Import\ImportSetting;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Services\Import\ImportSettingService;

class ImportSettingController extends Controller
{
    public function __construct(private readonly ImportSettingService $importSettingService) {}

    public function index(Request $request): View
    {
        $user = $request->user();
        $importSettings = $this->importSettingService->all($user);
        return view('import.import_setting.index', compact('importSettings'));
    }

    public function edit(ImportSetting $importSetting, Request $request): View
    {
        // @todo add update route (PUT)
        $user = $request->user();
        if ($importSetting->user_id !== $user->id) {
            abort(403);
        }

        return view('import.import_setting.edit', compact('importSetting'));
    }

    public function show(ImportSetting $importSetting, Request $request): View
    {
        $user = $request->user();
        if ($importSetting->user_id !== $user->id) {
            abort(403);
        }

        return view('import.import_setting.show', compact('importSetting'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'file_extension' => 'required|string',
            'delimiter' => 'required|string',
            'enclosure' => 'nullable|string',
            'start_row' => 'nullable|numeric',
            'escape_character' => 'nullable|string',
            'input_encoding' => 'nullable|string',
        ]);

        $importSetting = ImportSetting::create($validatedData);

        return redirect()
            ->route('import.import-setting.show', ['id' => $importSetting->id])
            ->with('success', 'Import setting created successfully.');
    }
}

