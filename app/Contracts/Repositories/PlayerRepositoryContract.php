<?php

declare(strict_types = 1);

namespace App\Contracts\Repositories;

use App\Models\Player;
use Illuminate\Support\Collection;

interface PlayerRepositoryContract
{
    public function findByIds(array $ids): Collection;

    public function update(Player $item, array $data): Player;
}
