<?php

namespace App\Http\Controllers\Web\Import;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Services\Import\ColumnMappingService;
use App\Http\Requests\Web\Import\ColumnMapping\CreateRequest;

class ColumnsMappingController extends Controller
{
    public function __construct(private readonly ColumnMappingService $columnMappingService)
    {
    }

    public function index(Request $request): View
    {
        $user = $request->user();
        $columnsMappings = $this->columnMappingService->all($user);

        return view('import.columns_mapping.index', compact('columnsMappings'));
    }

    public function create(CreateRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user = $request->user();
        $this->columnMappingService->create($user, $data);

        return redirect()
            ->route('import.columns-mapping.index')
            ->with('success', 'Columns Mapping created successfully.');
    }
}
