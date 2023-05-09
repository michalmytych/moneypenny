<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class EmptyController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return redirect(route('home'));
    }
}
