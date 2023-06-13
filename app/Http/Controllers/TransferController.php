<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Requests\PlayersBuyRequest;
use App\Http\Requests\PlayersSellRequest;
use App\Http\Resources\CountryResource;
use App\Http\Resources\TransferResource;
use App\Services\TransferServices;
use Illuminate\Http\Resources\Json\JsonResource;

class TransferController extends ApiController
{
    public function findItems(
        TransferServices $service,
    ): JsonResource
    {
        $filters = $this->getInputFilters();
        $page = $this->getInputPage();
        $perPage = $this->getInputPerPage();
        $sort = $this->getInputSort();

        $items = $service->findItems($filters, $page, $perPage, $sort);

        return CountryResource::collection($items);
    }

    public function sellPlayers(
        PlayersSellRequest $request,
        TransferServices   $service,
    ): JsonResource
    {
        $data = $request->validated();
        $items = $service->sellPlayers($data['items']);

        return TransferResource::collection($items);
    }

    public function buyPlayers(
        PlayersBuyRequest $request,
        TransferServices  $service,
    ): JsonResource
    {
        $data = $request->validated();

        $items = $service->buyPlayers($data['items']);

        return TransferResource::collection($items);
    }
}
