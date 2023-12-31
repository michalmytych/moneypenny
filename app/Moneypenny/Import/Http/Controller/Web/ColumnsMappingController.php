<?php

namespace App\Moneypenny\Import\Http\Controller\Web;

use App\Moneypenny\Import\Http\Requests\Web\CreateColumnMappingRequest;
use App\Moneypenny\Import\Services\ColumnMappingService;
use App\Shared\Http\Controller\Controller;
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

    public function create(CreateColumnMappingRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user = $request->user();
        $this->columnMappingService->create($user, $data);

        return redirect()
            ->route('import.columns-mapping.index')
            ->with('success', 'Columns Mapping created successfully.');
    }
}
