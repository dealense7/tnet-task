<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Contracts\Repositories\PlayerRepositoryContract;
use App\Models\Player;
use Illuminate\Support\Collection;

class PlayerRepository implements PlayerRepositoryContract
{

    public function findByIds(array $ids): Collection
    {
        return $this->getModel()
            ->with([
                'team',
                'country',
            ])
            ->whereIn('id', $ids)->get();
    }

    public function update(Player $item, array $data): Player
    {
        $item->fill($data);
        $item->saveOrFail();

        $item->load([
            'team',
            'country',
        ]);

        return $item;
    }

    public function getModel(): Player
    {
        return new Player();
    }
}
