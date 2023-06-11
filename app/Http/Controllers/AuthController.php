<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\UserServices;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(LoginRequest $request, UserServices $services)
    {
        $data = $request->validated();

        $user = $services->findByEmail($request->email);

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json(['token' => $token]);
    }
}
