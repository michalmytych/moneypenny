<?php

namespace App\Http\Controllers\Web\Import;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Import\ImportSetting;
use Illuminate\Http\RedirectResponse;
use App\Services\Import\ImportService;
use App\Services\Import\ImportSettingService;
use App\Http\Requests\Web\Import\ImportSetting\UpdateRequest;
use App\Http\Requests\Web\Import\ImportSetting\CreateRequest;

class ImportSettingController extends Controller
{
    public function __construct(
        private readonly ImportService $importService,
        private readonly ImportSettingService $importSettingService
    ) {
    }

    public function index(Request $request): View
    {
        $user = $request->user();
        $importSettings = $this->importSettingService->all($user);
        $columnConfigurationExist = $this->importService->columnConfigurationForUserExist($user);

        return view('import.import_setting.index', compact('importSettings', 'columnConfigurationExist'));
    }

    public function edit(mixed $id, Request $request): View
    {
        $user = $request->user();
        $importSetting = $this->importSettingService->findOrFail($id);

        if ($importSetting->user_id !== $user->id) {
            abort(403);
        }

        $columnConfigurationExist = $this->importService->columnConfigurationForUserExist($user);

        return view('import.import_setting.edit', compact('importSetting', 'columnConfigurationExist'));
    }

    public function update(mixed $id, UpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $importSetting = $this->importSettingService->findOrFail($id);
        $data = $request->validated();

        if ($importSetting->user_id !== $user->id) {
            abort(403);
        }

        $importSetting = $this->importSettingService->update($importSetting, $data);

        return to_route('import.import-setting.show', ['id' => $importSetting->id]);
    }

    public function show(mixed $id, Request $request): View
    {
        $user = $request->user();
        $importSetting = $this->importSettingService->findOrFail($id);

        if ($importSetting->user_id !== $user->id) {
            abort(403);
        }

        return view('import.import_setting.show', compact('importSetting'));
    }

    public function create(CreateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validatedData = $request->validated();

        $validatedData['user_id'] = $user->id;
        $importSetting = ImportSetting::create($validatedData);

        return redirect()
            ->route('import.import-setting.show', ['id' => $importSetting->id])
            ->with('success', 'Import setting created successfully.');
    }
}

