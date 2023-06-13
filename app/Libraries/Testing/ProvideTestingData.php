<?php

declare(strict_types = 1);

namespace App\Libraries\Testing;

use App\Models\Country;
use App\Models\Player;
use App\Models\Team;
use App\Models\Transfer;
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

    public static function createTeamRandomItems(array $params = [], int $count = 5): Collection
    {
        return Team::factory()->count($count)->create($params);
    }

    public static function createCountryRandomItems(array $params = [], int $count = 5): Collection
    {
        return Country::factory()->count($count)->create($params);
    }

    public static function createPlayerRandomItems(array $params = [], int $count = 5): Collection
    {
        return Player::factory()->count($count)->create($params);
    }

    public static function createTransferRandomItems(array $params = [], int $count = 5): Collection
    {
        return Transfer::factory()->count($count)->create($params);
    }
}
