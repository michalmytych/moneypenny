<?php

namespace App\Shared\Http\Controller\Web;

use App\Shared\Http\Controller\Controller;
use App\Shared\Services\Meta\MetaService;
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
