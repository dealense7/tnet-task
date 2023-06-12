<?php

declare(strict_types = 1);

namespace App\Http\Resources;


class UserResource extends BaseResource
{
    public function transformToExternal(): array
    {
        /** @var \App\Models\User $user */
        $user = $this;
        return [
            'name'  => $user->getName(),
            'email' => $user->getEmail(),
        ];
    }
}
