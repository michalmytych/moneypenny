<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Services\Auth\Api\UserService;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    public function register(RegisterRequest $request): Response
    {
        $result = $this->userService->register(
            $request->validated()
        );

        return response($result, 201);
    }

    public function login(LoginRequest $request): Response
    {
        try {
            $result = $this->userService->login($request->validated());

        } catch (Throwable) {
            return response([
                'message' => 'Bad credential provided!',
            ], 401);
        }

        return response($result);
    }

    public function logout(Request $request): Response
    {
        $this->userService->logout($request->user());

        return response([
            'message' => 'User logged out successfully.',
        ]);
    }

    public function user(Request $request): Response
    {
        return response([
            'user'  => $request->user(),
            'token' => $request->bearerToken(),
        ]);
    }
}
