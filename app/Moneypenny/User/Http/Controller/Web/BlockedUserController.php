<?php

namespace App\Moneypenny\User\Http\Controller\Web;

use App\Shared\Http\Controller\Controller;
use Illuminate\View\View;

class BlockedUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('web')->except(['index']);
    }

    public function index(): View
    {
        return view('blocked.index');
    }
}
