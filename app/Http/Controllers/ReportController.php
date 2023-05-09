<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\Transaction\Report\ReportService;

class ReportController extends Controller
{
    public function __construct(private readonly ReportService $reportService) {}

    public function periodic(Request $request): View
    {
        $data = $this->reportService->getPeriodicReport(
            $request->input('month'),
            $request->user()->id
        );

        return view('reports.periodic.month', compact('data'));
    }
}
