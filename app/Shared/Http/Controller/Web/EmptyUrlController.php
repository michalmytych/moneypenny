<?php

namespace App\Shared\Http\Controller\Web;

use App\Shared\Http\Controller\Controller;
use Illuminate\Http\RedirectResponse;

class EmptyUrlController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return to_route('home');
    }
}
