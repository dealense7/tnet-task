<?php

declare(strict_types = 1);

namespace App\Http\Resources;

/**
 * @property string $plainTextToken
 */
class TokenResource extends BaseResource
{
    public function transformToExternal(): array
    {
        return [
            'token' => $this->plainTextToken,
        ];
    }
}
