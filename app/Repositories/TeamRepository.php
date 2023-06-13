<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Contracts\Repositories\TeamRepositoryContract;
use App\Models\Team;

class TeamRepository implements TeamRepositoryContract
{

    public function findByUserId(int $userId): ?Team
    {
        /** @var \App\Models\Team|null $team */
        $team = $this->getModel()
            ->with([
                'players',
            ])
            ->firstWhere('user_id', $userId);

        return $team;
    }

    public function findById(int $id): ?Team
    {
        /** @var \App\Models\Team|null $team */
        $team = $this->getModel()
            ->with([
                'players',
            ])->find($id);

        return $team;
    }

    public function update(Team $item, array $data): Team
    {
        $item->fill($data);
        $item->saveOrFail();

        $item->load([
            'players',
        ]);

        return $item;
    }

    public function getModel(): Team
    {
        return new Team();
    }
}
