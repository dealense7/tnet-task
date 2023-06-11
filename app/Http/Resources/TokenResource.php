<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Laravel\Sanctum\NewAccessToken;

class TokenResource extends BaseResource
{
    public function structure(): array
    {
        /** @var NewAccessToken $token */
        $token = $this;
        return [
            'token' => $token->plainTextToken
        ];
    }
}
