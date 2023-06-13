<?php

declare(strict_types = 1);

namespace App\Contracts\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CountryRepositoryContract
{
    public function findItems(array $filters = [], int $page = 1, ?int $perPage = null, ?string $sort = null): LengthAwarePaginator;
}
