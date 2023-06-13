<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Contracts\Repositories\CountryRepositoryContract;
use App\Models\Country;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CountryRepository implements CountryRepositoryContract
{
    public function findItems(
        array   $filters = [],
        int     $page = 1,
        ?int    $perPage = null,
        ?string $sort = null
    ): LengthAwarePaginator
    {
        $model = $this->getModel();
        $items = $model
            ->filterByKeyWord($filters);

        foreach ($model->parseSort($sort) as $column => $direction) {
            $items = $items->orderBy($column, $direction);
        }
        $items = $items->orderBy('id', 'desc');

        return $items->paginate($model->getValidPerPage($perPage), ['*'], 'page', $page);
    }

    public function getModel(): Country
    {
        return new Country();
    }
}
