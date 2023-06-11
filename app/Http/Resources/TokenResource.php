<?php

declare(strict_types = 1);

namespace App\Http\Resources;


class TokenResource extends BaseResource
{
    public function structure(): array
    {
        /** @var NewAccessToken $token */
        $token = $this;
        return [
            'token' => $token->plainTextToken,
        ];
    }
}
