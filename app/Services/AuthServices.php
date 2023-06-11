<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryContract;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\NewAccessToken;

class AuthServices
{
    public function login(string $password, ?User $user): NewAccessToken
    {
        if (!$user || !Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken('auth-token');
    }
}
