<?php

namespace App\Http\Controllers\Web;

use Illuminate\View\View;
use App\Http\Controllers\Controller;

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
