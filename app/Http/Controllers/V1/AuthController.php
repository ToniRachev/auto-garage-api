<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RegisterAuthRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use App\Responses\V1\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(Request $request) {}

    public function register(RegisterAuthRequest $request)
    {
        // Wrap in a transaction to ensure user and token are created together or not at all
        $result = DB::transaction(function () use ($request) {
            $user = User::create([
                "name" => $request->validated('name'),
                'email' => $request->validated('email'),
                'password' => Hash::make($request->validated('password')),
            ]);

            $token = $user->createToken("$user->name auth token")->plainTextToken;

            return compact('user', 'token');
        });



        return ApiResponse::created(
            'User was created successfully',
            [
                'user' => new UserResource($result['user']),
                'token' => $result['token']
            ]
        );
    }
}
