<?php

namespace App\Moneypenny\Report\Http\Controller\Web;

use App\Shared\Http\Controller\Controller;
use App\Transaction\Report\ReportService;
use Illuminate\Http\Request;
use Illuminate\View\View;

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