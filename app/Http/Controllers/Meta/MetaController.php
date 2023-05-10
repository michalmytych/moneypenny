<?php

namespace App\Http\Controllers\Meta;

use Illuminate\View\View;
use App\Services\Meta\MetaService;
use App\Http\Controllers\Controller;

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
