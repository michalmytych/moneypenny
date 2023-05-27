<?php

namespace App\Http\Controllers\Web\Transaction;

use App\Http\Controllers\Controller;
use App\Services\Transaction\Report\ReportService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __construct(private readonly ReportService $reportService) {}

    public function index(): View
    {
        $reports = $this->reportService->all();
        return view('reports.index', compact('reports'));
    }

    public function periodic(Request $request): View
    {
        $data = $this->reportService->getPeriodicReport(
            $request->input('month'),
            $request->user()->id
        );

        return view('reports.periodic.month', compact('data'));
    }
}
