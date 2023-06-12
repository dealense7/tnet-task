<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\TokenResource;
use App\Http\Resources\UserResource;
use App\Services\AuthServices;
use App\Services\UserServices;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends ApiController
{
    public function user(
        AuthServices $services,
    ): JsonResource
    {
        $user = $services->getUser();

        return UserResource::make($user);
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
