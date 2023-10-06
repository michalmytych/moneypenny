<?php

namespace App\Http\Controllers\Web\Home;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Home\HomePageServiceInterface;

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
