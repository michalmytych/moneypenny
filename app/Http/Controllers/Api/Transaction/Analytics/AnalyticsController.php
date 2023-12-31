<?php

namespace App\Http\Controllers\Api\Transaction\Analytics;

use App\Http\Controllers\Controller;
use App\Moneypenny\Transaction\Services\Analytics\AnalyticsService;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function __construct(private readonly AnalyticsService $analyticsService) {}

    public function index(Request $request): array
    {
        $user = $request->user();
        $chartQueryId = $request->get('chart_id');

        return $this->analyticsService->getChartData($user, $chartQueryId);
    }
}
