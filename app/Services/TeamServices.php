<?php

declare(strict_types = 1);

namespace App\Services;

use App\Contracts\AuthUserContract;
use App\Contracts\Repositories\TeamRepositoryContract;
use App\DataTransferObjects\TeamDto;
use App\Enums\PlayerPosition;
use App\Exceptions\HttpException;
use App\Exceptions\ItemNotFoundException;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Collection;

class TeamServices
{
    public function __construct(
        private readonly TeamRepositoryContract $repository,
        private readonly ?AuthUserContract $user,
    )
    {
    }

    public function findByUserId(int $userId): Team
    {
        $team = $this->repository->findByUserId($userId);
        if (!$team) {
            throw new ItemNotFoundException();
        }

        return $team;
    }

    public function findByIdOrFail(int $id): Team
    {
        $team = $this->repository->findById($id);
        if (!$team) {
            throw new ItemNotFoundException();
        }

        return $team;
    }

    public function update(Team $item, array $data): Team
    {
        if ($item->getUserId() !== $this->user->getId())
        {
            throw new HttpException('This is not your team', 403);
        }

        $dto = TeamDto::toInternal($data);

        return $this->repository->update($item, $dto);
    }

    public function generateTeam(User $user): Team
    {
        /** @var \App\Models\Team $team */
        $team = Team::factory()->create([
            'user_id' => $user->getId(),
            'balance' => 5000000 * 100,
        ]);

        $this->generatePlayers([
            'team_id' => $team->getId(),
            'type'    => PlayerPosition::GOALKEEPER->value,
        ], 3);

        $this->generatePlayers([
            'team_id' => $team->getId(),
            'type'    => PlayerPosition::DEFENDER->value,
        ], 6);

        $this->generatePlayers([
            'team_id' => $team->getId(),
            'type'    => PlayerPosition::MIDFIELDER->value,
        ], 6);

        $this->generatePlayers([
            'team_id' => $team->getId(),
            'type'    => PlayerPosition::ATTACKER->value,
        ], 5);

        return $team;
    }

    public function generatePlayers(array $params = [], int $count = 1): Collection
    {
        return Player::factory()->count($count)->create([
            ...$params,
            'market_value' => 1000000 * 100,
        ]);
    }
}
