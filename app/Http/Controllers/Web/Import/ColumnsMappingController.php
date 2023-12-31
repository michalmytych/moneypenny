<?php

namespace App\Http\Controllers\Web\Import;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Import\ColumnMapping\CreateRequest;
use App\Moneypenny\Import\Services\ColumnMappingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
