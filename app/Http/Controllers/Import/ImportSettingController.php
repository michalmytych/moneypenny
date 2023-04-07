<?php

namespace App\Http\Controllers\Import;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Import\ImportSetting;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class ImportSettingController extends Controller
{
    public function index(): View
    {
        $importSettings = ImportSetting::latest()->get();
        return view('import.import_setting.index', compact('importSettings'));
    }

    public function edit(ImportSetting $importSetting): View
    {
        return view('import.import_setting.edit', compact('importSetting'));
    }

    public function show(ImportSetting $importSetting): View
    {
        return view('import.import_setting.show', compact('importSetting'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name'             => 'required|string',
            'file_extension'   => 'required|string',
            'delimiter'        => 'required|string',
            'enclosure'        => 'nullable|string',
            'start_row'        => 'nullable|numeric',
            'escape_character' => 'nullable|string',
            'input_encoding'   => 'nullable|string',
        ]);

        $importSetting = ImportSetting::create($validatedData);

        return redirect()
            ->route('import.import-setting.show', ['id' => $importSetting->id])
            ->with('success', 'Import setting created successfully.');
    }
}

