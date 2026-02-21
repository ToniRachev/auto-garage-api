<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginAuthRequest;
use App\Http\Requests\V1\RegisterAuthRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use App\Responses\V1\ApiResponse;
use App\Services\V1\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    public function login(LoginAuthRequest $request)
    {
        $result = $this->authService->login($request->validated());

        return ApiResponse::ok(
            'User loggin successfully.',
            [
                'user' => new UserResource($result['user']),
                'token' => $result['token'],
            ]
        );
    }

    public function register(RegisterAuthRequest $request)
    {
        $result = $this->authService->register($request->validated());

        return ApiResponse::created(
            'User was created successfully',
            [
                'user' => new UserResource($result['user']),
                'token' => $result['token']
            ]
        );
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());
        return ApiResponse::noContent();
    }
}
