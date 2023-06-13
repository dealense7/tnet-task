<?php

declare(strict_types=1);

namespace Tests\Feature\Transfer;

use App\Libraries\Testing\ProvideTestingData;
use App\Models\Transfer;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\TestCase;

class SellPlayersTest extends TestCase
{
    #[Test()]
    public function it_should_raise_unauthenticated(): void
    {
        $response = $this->jsonWithHeader('POST', $this->url('transfers/sell'));

        $response->assertUnauthorized();
    }

    #[Test()]
    public function it_should_raise_validation_error(): void
    {
        ProvideTestingData::createRandomUserAndAuthorize();
        $data = [];
        $response = $this->jsonWithHeader('POST', $this->url('transfers/sell'), $data);
        $response->assertJsonValidationErrors(['items']);
    }

    #[Test()]
    public function it_should_raise_forbidden_for_tying_to_sell_not_your_players(): void
    {
        ProvideTestingData::createRandomUserAndAuthorize();
        ProvideTestingData::createCountryRandomItems([], 1);

        $user = ProvideTestingData::createUserRandomItems([], 1)->first();
        $team = ProvideTestingData::createTeamRandomItems([
            'user_id' => $user->getId(),
        ], 1)->first();
        $player = ProvideTestingData::createPlayerRandomItems([
            'team_id' => $team->getId(),
        ], 1)->first();

        $data = [
            'items' => [
                [
                    'playerId' => $player->getId(),
                    'price' => 1500000,
                ],
            ],
        ];

        $response = $this->jsonWithHeader('POST', $this->url('transfers/sell'), $data);

        $response->assertJsonValidationErrors('items');
    }

    #[Test()]
    public function it_should_set_player_in_transfer_list(): void
    {
        $user = ProvideTestingData::createRandomUserAndAuthorize();
        ProvideTestingData::createCountryRandomItems([], 1);

        $team = ProvideTestingData::createTeamRandomItems([
            'user_id' => $user->getId(),
        ], 1)->first();
        $player = ProvideTestingData::createPlayerRandomItems([
            'team_id' => $team->getId(),
        ], 1)->first();

        $data = [
            'items' => [
                [
                    'playerId' => $player->getId(),
                    'price' => 1500000,
                ],
            ],
        ];

        $response = $this->jsonWithHeader('POST', $this->url('transfers/sell'), $data);

        $response->assertOk();
        $response->assertJsonDataCollectionStructure($this->transferStructure([
            'player',
        ]), false);

        $this->assertDatabaseHas(
            (new Transfer())->getTable(),
            [
                'player_id' => $player->getId(),
                'price' => 1500000 * 100,
            ]
        );
    }
}
