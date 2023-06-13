<?php

declare(strict_types = 1);

namespace App\Contracts\Repositories;

use App\Models\Team;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface TransferRepositoryContract
{
    public function findItems(array $filters = [], int $page = 1, ?int $perPage = null, ?string $sort = null): LengthAwarePaginator;

    public function findByIds(array $ids): Collection;

    public function sellPlayers(array $data): Collection;

    public function buyPlayers(Collection $players, Team $buyer): Collection;
}
