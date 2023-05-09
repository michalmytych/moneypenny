<?php

namespace App\Http\Controllers\Meta;

use App\Http\Controllers\Controller;
use App\Services\Meta\MetaService;
use Illuminate\View\View;

class MetaController extends Controller
{
    public function __construct(private readonly MetaService $metaService)
    {
    }

    public function index(): View
    {
        $appMetaData = $this->metaService->getAppMetaData();
        return view('meta.index', ['meta' => $appMetaData]);
    }
}
