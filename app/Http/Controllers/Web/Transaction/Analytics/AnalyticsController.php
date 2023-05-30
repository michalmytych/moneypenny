<?php

namespace App\Http\Controllers\Web\Transaction\Analytics;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function index(): View
    {
        return view('analytics.index');
    }
}
