<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Contracts\Repositories\TransferRepositoryContract;
use App\Enums\TransferTypes;
use App\Models\Team;
use App\Models\Transfer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class TransferRepository implements TransferRepositoryContract
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
            ->with([
                'player.team',
            ]);

        foreach ($model->parseSort($sort) as $column => $direction) {
            $items = $items->orderBy($column, $direction);
        }
        $items = $items->orderBy('id', 'desc');

        return $items->paginate($model->getValidPerPage($perPage), ['*'], 'page', $page);
    }

    public function findByIds(array $ids): Collection
    {
        return $this->getModel()
            ->with([
                'player.team',
            ])
            ->whereIn('id', $ids)->get();
    }

    public function sellPlayers(array $data): Collection
    {
        $model = $this->getModel();
        $transferIds = [];
        foreach ($data as $item) {
            $transfer = $model->create([
                'player_id' => $item['playerId'],
                'price'     => $item['price'] * 100,
            ]);
            $transfer->load(['player']);

            $transferIds[] = $transfer->getId();
        }

        return $model->whereIn('id', $transferIds)->with([
            'player.team',
        ])->get();
    }

    public function buyPlayers(Collection $transfers, Team $buyer): Collection
    {
        $model = $this->getModel();

        foreach ($transfers as $transfer) {
            $transfer->update([
                'buyer_id' => $buyer->getId(),
                'type'     => TransferTypes::SOLD,
            ]);
        }

        return $model->whereIn('id', $transfers->pluck('id')->toArray())->with([
            'player.team',
        ])->get();
    }

    public function getModel(): Transfer
    {
        return new Transfer();
    }
}
