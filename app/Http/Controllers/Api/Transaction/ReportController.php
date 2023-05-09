<?php

namespace App\Http\Controllers\Api\Transaction;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Transaction\Report\ReportService;

class ReportController extends Controller
{
    public function __construct(private readonly ReportService $reportService) {}

    public function avgExpenditures(): JsonResponse
    {
        $data = $this
            ->reportService
            ->getAvgExpendituresByDays(sinceDate: now()->subMonth(), toDate: now());

        return response()->json([
            'dataset' => $data
        ]);
    }

    public function avgIncomes(): JsonResponse
    {
        $data = $this
            ->reportService
            ->getAvgIncomesByDays(sinceDate: now()->subMonth(), toDate: now());

        return response()->json([
            'dataset' => $data
        ]);
    }
}
