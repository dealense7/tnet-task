<?php

declare(strict_types = 1);

namespace App\Services;

use App\Contracts\AuthUserContract;
use App\Contracts\Repositories\PlayerRepositoryContract;
use App\Contracts\Repositories\TransferRepositoryContract;
use App\Exceptions\HttpException;
use App\Repositories\TeamRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Connection;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class TransferServices
{
    public function __construct(
        private readonly TransferRepositoryContract $repository,
        private readonly TeamRepository             $teamRepository,
        private readonly PlayerRepositoryContract   $playerRepository,
        private readonly PlayerServices             $playerService,
        private readonly AuthUserContract           $user,
        private readonly Connection                 $database
    )
    {
    }

    public function findItems(array $filters = [], int $page = 1, ?int $perPage = null, ?string $sort = null): LengthAwarePaginator
    {
        return $this->repository->findItems($filters, $page, $perPage, $sort);
    }

    public function sellPlayers(array $data): Collection
    {
        $ids = Arr::pluck($data, 'playerId');

        $players = $this->playerService->findByIds($ids);

        $idsOfTeamOwners = $players->pluck('team')->pluck('user_id')->unique()->toArray();

        if (
            count($idsOfTeamOwners) > 1
            || !in_array($this->user->getId(), $idsOfTeamOwners)
        ) {
            throw new HttpException('You can only sell your own players', 403);
        }

        return $this->database->transaction(function () use ($data) {
            return $this->repository->sellPlayers($data);
        });
    }

    public function buyPlayers(array $data): Collection
    {
        $ids = Arr::pluck($data, 'transferId');

        $transfers = $this->repository->findByIds($ids);

        $idsOfTeamOwners = $transfers
            ->pluck('player')
            ->pluck('team')
            ->pluck('user_id')
            ->unique()
            ->toArray();

        if (
            in_array($this->user->getId(), $idsOfTeamOwners)
        ) {
            throw new HttpException('You can not but own player', 403);
        }


        if (
            $transfers->sum('price') > $this->user->team->getBalance()
        ) {
            throw new HttpException('Your team has not enough money', 403);
        }

        return $this->database->transaction(function () use ($transfers) {
            $transfers = $this->repository->buyPlayers($transfers, $this->user->team);
            // Update Team Balances
            // using different repositories will help to update cache if there is any logic after update
            $this->teamRepository->update(
                $this->user->team,
                [
                    'balance' => $this->user->team->getBalance() - $transfers->sum('price'),
                ]
            );

            /** @var \App\Models\Transfer $transfer */
            foreach ($transfers as $transfer) {
                $this->teamRepository->update(
                    $transfer->player->team,
                    [
                        'balance' => $transfer->player->team->getBalance() + $transfer->getPrice(),
                    ]
                );

                // Update Player Market Value
                $this->playerRepository->update(
                    $transfer->player,
                    [
                        'market_value' => $transfer->player->getMarketValue() + $transfer->player->getMarketValue() * rand(10, 100) / 100,
                    ]
                );
            }

            return $transfers;
        });
    }
}
