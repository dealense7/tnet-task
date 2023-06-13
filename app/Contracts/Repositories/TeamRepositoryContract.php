<?php

declare(strict_types = 1);

namespace App\Contracts\Repositories;

use App\Models\Team;

interface TeamRepositoryContract
{
    public function findByUserId(int $userId): ?Team;
}
