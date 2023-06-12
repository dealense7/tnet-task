<?php

declare(strict_types = 1);

namespace App\Services;

use App\Contracts\AuthUserContract;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\NewAccessToken;

class AuthServices
{
    public function __construct(
        private readonly ?AuthUserContract $user,
    )
    {
    }

    public function login(string $password, ?User $user): NewAccessToken
    {
        if (!$user || !Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $this->createToken($user, 'auth-token');
    }

    public function createToken(User $user, string $tokenName): NewAccessToken
    {
        return $user->createToken($tokenName);
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
