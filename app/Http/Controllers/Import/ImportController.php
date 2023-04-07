<?php

namespace App\Http\Controllers\Import;

use Illuminate\View\View;
use App\Models\Import\Import;
use App\Http\Controllers\Controller;

class ImportController extends Controller
{
    public function index(): View
    {
        $imports = Import::with('file')->latest()->get();
        return view('import.index', compact('imports'));
    }
}
