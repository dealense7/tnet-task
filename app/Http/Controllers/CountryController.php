<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Resources\CountryResource;
use App\Services\CountryServices;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryController extends ApiController
{
    public function findItems(
        CountryServices $service,
    ): JsonResource
    {
        $filters = $this->getInputFilters();
        $page = $this->getInputPage();
        $perPage = $this->getInputPerPage();
        $sort = $this->getInputSort();

        $items = $service->findItems($filters, $page, $perPage, $sort);

        return CountryResource::collection($items);
    }
}
