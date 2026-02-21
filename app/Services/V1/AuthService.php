<?php

namespace App\Services\V1;

use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;
use App\Exceptions\InvalidCredentialsException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

final class AuthService
{

    public function login($data): array
    {
        $user = User::where('email',  $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new InvalidCredentialsException();
        }

        $token = $this->generateToken($user);

        return compact('user', 'token');
    }

    public function register($data): array
    {
        // Wrap in a transaction to ensure user and token are created together or not at all
        return DB::transaction(function () use ($data) {
            $user = User::create([
                "name" => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $token = $user->createToken("$user->name auth token")->plainTextToken;

            return compact('user', 'token');
        });
    }

    private function generateToken(User $user): string
    {
        return $user->createToken("$user->name authToken")->plainTextToken;
    }

    public function logout(User $user): void
    {
        $token = $user->currentAccessToken();

        if ($token instanceof PersonalAccessToken) {
            $token->delete();
        }
    }
}
