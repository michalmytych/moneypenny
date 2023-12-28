<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\Api\UserService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SetupController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    public function setup(Request $request): View
    {
        $apiToken = $this->userService->getOrCreateApiToken($request->user());

        return view(
            'auth.setup', [
            'redirect' => route('setting.edit'),
            'currentApiToken' => $apiToken
            ]
        );
    }
}
