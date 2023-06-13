<?php

declare(strict_types = 1);

namespace App\Services;

use App\Contracts\Repositories\PlayerRepositoryContract;
use Illuminate\Support\Collection;

class PlayerServices
{
    public function __construct(
        private readonly PlayerRepositoryContract $repository,
    )
    {
    }

    public function findByIds(array $ids): Collection
    {
        return $this->repository->findByIds($ids);
    }
}
