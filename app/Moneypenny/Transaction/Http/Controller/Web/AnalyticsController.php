<?php

namespace App\Moneypenny\Transaction\Http\Controller\Web;

use App\Shared\Http\Controller\Controller;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function index(): View
    {
        return view('analytics.index');
    }
}
