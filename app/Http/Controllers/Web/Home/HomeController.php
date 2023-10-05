<?php

namespace App\Http\Controllers\Web\Home;

use App\Http\Controllers\Controller;
use App\Services\Home\HomePageServiceInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(private readonly HomePageServiceInterface $homeService)
    {
    }

    public function index(Request $request): View
    {
        $homeData = $this->homeService->getHomeData($request->user());

        return view('home.index', $homeData);
    }
}
