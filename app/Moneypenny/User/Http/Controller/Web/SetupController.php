<?php

namespace App\Moneypenny\User\Http\Controller\Web;

use App\Services\Auth\Api\UserService;
use App\Shared\Http\Controller\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SetupController extends Controller
{
    public function __construct(private readonly UserService $userService) {}

    public function setup(Request $request): View
    {
        $apiToken = $this->userService->getOrCreateApiToken($request->user());

        return view('auth.setup', [
            'redirect' => route('setting.edit'),
            'currentApiToken' => $apiToken
        ]);
    }
}
