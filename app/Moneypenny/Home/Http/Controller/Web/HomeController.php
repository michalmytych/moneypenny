<?php

namespace App\Moneypenny\Home\Http\Controller\Web;

use App\Moneypenny\Home\Contracts\HomePageServiceInterface;
use App\Shared\Http\Controller\Controller;
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
