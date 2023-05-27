<?php

namespace App\Http\Controllers\Web\Utils;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class EmptyUrlController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return redirect(route('home'));
    }
}
