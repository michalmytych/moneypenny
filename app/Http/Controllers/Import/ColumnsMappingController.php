<?php

namespace App\Http\Controllers\Import;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Import\ColumnsMapping;
use Illuminate\Http\RedirectResponse;

class ColumnsMappingController extends Controller
{
    public function index(): View
    {
        $columnsMappings = ColumnsMapping::latest()->get();
        return view('import.columns_mapping.index', compact('columnsMappings'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'                          => 'required|string',
            'transaction_date_column_index' => 'nullable|numeric',
            'volume_column_index'           => 'nullable|numeric',
            'accounting_date_column_index'  => 'nullable|numeric',
            'sender_column_index'           => 'nullable|numeric',
            'receiver_column_index'         => 'nullable|numeric',
            'description_column_index'      => 'nullable|numeric',
            'currency_column_index'         => 'nullable|numeric',
        ]);

        ColumnsMapping::create($data);

        return redirect()
            ->route('import.columns-mapping.index')
            ->with('success', 'Columns Mapping created successfully.');
    }
}
