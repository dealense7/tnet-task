<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\TokenResource;
use App\Services\AuthServices;
use App\Services\UserServices;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthController extends ApiController
{
    public function login(
        LoginRequest $request,
        UserServices $services,
        AuthServices $authServices
    ): JsonResource
    {
        $data = $request->validated();

        $user = $services->findByEmail($data['email']);
        $accessToken = $authServices->login($data['password'], $user);

        return TokenResource::make($accessToken);
    }

    public function register(
        RegisterRequest $request,
        UserServices    $services,
        AuthServices    $authServices
    ): JsonResource
    {
        $data = $request->validated();

        $user = $services->create($data);
        $accessToken = $authServices->createToken($user, 'register-token');

        return TokenResource::make($accessToken);
    }
}
