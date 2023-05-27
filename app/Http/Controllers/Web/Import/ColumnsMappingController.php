<?php

namespace App\Http\Controllers\Web\Import;

use App\Http\Controllers\Controller;
use App\Services\Import\ColumnMappingService;
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

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
            'transaction_date_column_index' => 'nullable|numeric',
            'volume_column_index' => 'nullable|numeric',
            'accounting_date_column_index' => 'nullable|numeric',
            'sender_column_index' => 'nullable|numeric',
            'receiver_column_index' => 'nullable|numeric',
            'description_column_index' => 'nullable|numeric',
            'currency_column_index' => 'nullable|numeric',
            'sender_account_number_index' => 'nullable|numeric',
            'receiver_account_number_index' => 'nullable|numeric',
        ]);

        $user = $request->user();
        $this->columnMappingService->create($user, $data);

        return redirect()
            ->route('import.columns-mapping.index')
            ->with('success', 'Columns Mapping created successfully.');
    }
}
