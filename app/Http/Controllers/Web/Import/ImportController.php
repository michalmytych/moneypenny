<?php

namespace App\Http\Controllers\Web\Import;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Import\ImportService;

class ImportController extends Controller
{
    public function __construct(private readonly ImportService $importService) {}

    public function index(Request $request): View
    {
        $user = $request->user();
        $imports = $this->importService->all($user);

        return view('import.index', compact('imports'));
    }
}
