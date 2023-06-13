<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Contracts\Repositories\TeamRepositoryContract;
use App\Models\Team;

class TeamRepository implements TeamRepositoryContract
{

    public function findByUserId(int $userId): ?Team
    {
        $team = $this->getModel()
            ->with([
                'players',
            ])
            ->where('user_id', $userId);

        return $team->first();
    }

    public function getModel(): Team
    {
        return new Team();
    }
}
