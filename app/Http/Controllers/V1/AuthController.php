<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RegisterAuthRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use App\Responses\V1\ApiResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request) {}

    public function register(RegisterAuthRequest $request)
    {
        $user = User::create($request->validated());
        $token = $user->createToken("$user->name auth token")->plainTextToken;

        return ApiResponse::created(
            'User was created successfully',
            [
                'user' => $user,
                'token' => $token
            ]
        );
    }
}
