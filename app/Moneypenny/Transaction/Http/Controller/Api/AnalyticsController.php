<?php

namespace App\Moneypenny\Transaction\Http\Controller\Api;

use App\Moneypenny\Transaction\Services\Analytics\AnalyticsService;
use App\Shared\Http\Controller\Controller;
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
