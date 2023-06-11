<?php

namespace App\Libraries\Testing;

use App\Models\User;
use Illuminate\Support\Collection;

class ProvideTestingData
{
    public static function createUserRandomItems(array $params = [], int $count = 5): Collection
    {
        return User::factory()->count($count)->create($params);
    }
}
