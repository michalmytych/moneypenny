<?php

namespace App\Moneypenny\Import\Http\Controller\Web;

use App\Moneypenny\Import\Services\ImportService;
use App\Shared\Http\Controller\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
