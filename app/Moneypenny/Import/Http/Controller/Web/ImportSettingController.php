<?php

namespace App\Moneypenny\Import\Http\Controller\Web;

use App\Moneypenny\Import\Http\Requests\Web\CreateImportSettingRequest;
use App\Moneypenny\Import\Http\Requests\Web\UpdateImportSettingRequest;
use App\Moneypenny\Import\Models\ImportSetting;
use App\Moneypenny\Import\Services\ImportService;
use App\Moneypenny\Import\Services\ImportSettingService;
use App\Shared\Http\Controller\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ImportSettingController extends Controller
{
    public function __construct(
        private readonly ImportService $importService,
        private readonly ImportSettingService $importSettingService
    ) {}

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

    public function update(mixed $id, UpdateImportSettingRequest $request): RedirectResponse
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

    public function create(CreateImportSettingRequest $request): RedirectResponse
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
