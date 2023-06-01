<?php

namespace App\Http\Controllers;

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
