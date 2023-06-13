<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\PlayerPosition;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Collection;

class TeamServices
{
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
