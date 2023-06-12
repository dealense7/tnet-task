<?php

declare(strict_types = 1);

namespace App\Libraries\Testing;

use App\Models\User;
use Illuminate\Support\Collection;
use Laravel\Sanctum\Sanctum;

class ProvideTestingData
{
    public static function createUserRandomItems(array $params = [], int $count = 5): Collection
    {
        return User::factory()->count($count)->create($params);
    }

    public static function createRandomUserAndAuthorize(array $params = []): User
    {
        /** @var \App\Models\User $user */
        $user = self::createUserRandomItems($params, 1)->first();

        Sanctum::actingAs($user);

        return $user;
    }
}
