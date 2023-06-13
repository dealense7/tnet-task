<?php

declare(strict_types = 1);

namespace App\Services;

use App\Contracts\Repositories\CountryRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CountryServices
{
    public function __construct(
        private readonly CountryRepositoryContract $repository,
    )
    {
    }

    public function findItems(array $filters = [], int $page = 1, ?int $perPage = null, ?string $sort = null): LengthAwarePaginator
    {
        return $this->repository->findItems($filters, $page, $perPage, $sort);
    }
}
