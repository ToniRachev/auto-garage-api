<?php

namespace App\Services\V1;

use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;
use App\Exceptions\InvalidCredentialsException;
use Illuminate\Support\Facades\Hash;

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
