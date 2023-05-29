<?php

namespace App\Http\Controllers\Web\Import;

use App\Http\Controllers\Controller;
use App\Models\Import\ImportSetting;
use App\Services\Import\ImportSettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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

    public function show(mixed $id, Request $request): View
    {
        $user = $request->user();
        $importSetting = ImportSetting::findOrFail($id);
        if ($importSetting->user_id !== $user->id) {
            abort(403);
        }

        return view('import.import_setting.show', compact('importSetting'));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        $validatedData = $request->validate([
            'name' => 'required|string',
            'file_extension' => 'required|string',
            'delimiter' => 'required|string',
            'enclosure' => 'nullable|string',
            'start_row' => 'nullable|numeric',
            'escape_character' => 'nullable|string',
            'input_encoding' => 'nullable|string',
        ]);

        $validatedData['user_id'] = $user->id;
        $importSetting = ImportSetting::create($validatedData);

        return redirect()
            ->route('import.import-setting.show', ['id' => $importSetting->id])
            ->with('success', 'Import setting created successfully.');
    }
}

