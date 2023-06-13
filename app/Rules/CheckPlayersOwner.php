<?php

namespace App\Rules;

use App\Contracts\Repositories\PlayerRepositoryContract;
use App\Exceptions\HttpException;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Arr;

class CheckPlayersOwner implements ValidationRule
{
    public function __construct(
        private readonly PlayerRepositoryContract $playerRepository
    )
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $ids = Arr::pluck($value, 'playerId');

        $players = $this->playerRepository->findByIds($ids);

        $idsOfTeamOwners = $players->pluck('team')->pluck('user_id')->unique()->toArray();

        $user = auth()->user();

        if (
            count($idsOfTeamOwners) > 1
            || !in_array($user->getId(), $idsOfTeamOwners)
        ) {
            $fail('You can only sell your own players');
        }
    }
}
