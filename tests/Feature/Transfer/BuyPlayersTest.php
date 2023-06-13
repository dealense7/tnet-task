<?php

declare(strict_types = 1);

namespace Tests\Feature\Transfer;

use App\Enums\TransferTypes;
use App\Libraries\Testing\ProvideTestingData;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\TestCase;

class BuyPlayersTest extends TestCase
{
    #[Test()]
    public function it_should_raise_unauthenticated(): void
    {
        $response = $this->jsonWithHeader('POST', $this->url('transfers/buy'));

        $response->assertUnauthorized();
    }

    #[Test()]
    public function it_should_raise_validation_error(): void
    {
        ProvideTestingData::createRandomUserAndAuthorize();
        $data = [];
        $response = $this->jsonWithHeader('POST', $this->url('transfers/buy'), $data);
        $response->assertJsonValidationErrors(['items']);
    }

    #[Test()]
    public function it_should_raise_forbidden_for_tying_to_buy_own_players(): void
    {
        $user = ProvideTestingData::createRandomUserAndAuthorize();
        ProvideTestingData::createCountryRandomItems([], 1);

        $team = ProvideTestingData::createTeamRandomItems([
            'user_id' => $user->getId(),
        ], 1)->first();
        $player = ProvideTestingData::createPlayerRandomItems([
            'team_id' => $team->getId(),
        ], 1)->first();

        $transfer = ProvideTestingData::createTransferRandomItems([
            'player_id' => $player,
        ], 1)->first();

        $data = [
            'items' => [
                [
                    'transferId' => $transfer->getId(),
                ],
            ],
        ];

        $response = $this->jsonWithHeader('POST', $this->url('transfers/buy'), $data);

        $response->assertForbidden();
    }

    #[Test()]
    public function it_should_raise_forbidden_for_not_enough_money(): void
    {
        $buyer = ProvideTestingData::createRandomUserAndAuthorize();
        ProvideTestingData::createCountryRandomItems([], 1);

        ProvideTestingData::createTeamRandomItems([
            'user_id' => $buyer->getId(),
            'balance' => 1,
        ], 1)->first();

        $user = ProvideTestingData::createUserRandomItems([], 1)->first();
        $team = ProvideTestingData::createTeamRandomItems([
            'user_id' => $user->getId(),
        ], 1)->first();
        $player = ProvideTestingData::createPlayerRandomItems([
            'team_id' => $team->getId(),
        ], 1)->first();

        $transfer = ProvideTestingData::createTransferRandomItems([
            'player_id' => $player,
            'price'     => 100,
        ], 1)->first();

        $data = [
            'items' => [
                [
                    'transferId' => $transfer->getId(),
                ],
            ],
        ];

        $response = $this->jsonWithHeader('POST', $this->url('transfers/buy'), $data);

        $response->assertForbidden();
    }

    #[Test()]
    public function it_should_buy_a_player(): void
    {

        $buyer = ProvideTestingData::createRandomUserAndAuthorize();
        ProvideTestingData::createCountryRandomItems([], 1);

        $buyerTeam = ProvideTestingData::createTeamRandomItems([
            'user_id' => $buyer->getId(),
            'balance' => 100,
        ], 1)->first();

        $user = ProvideTestingData::createUserRandomItems([], 1)->first();
        $team = ProvideTestingData::createTeamRandomItems([
            'user_id' => $user->getId(),
            'balance' => 0,
        ], 1)->first();
        $player = ProvideTestingData::createPlayerRandomItems([
            'team_id'      => $team->getId(),
            'market_value' => 100,
        ], 1)->first();

        $transfer = ProvideTestingData::createTransferRandomItems([
            'player_id' => $player,
            'price'     => 10,
        ], 1)->first();

        $data = [
            'items' => [
                [
                    'transferId' => $transfer->getId(),
                ],
            ],
        ];

        $response = $this->jsonWithHeader('POST', $this->url('transfers/buy'), $data);

        $response->assertOk();
        $response->assertJsonDataCollectionStructure($this->transferStructure([
            'player',
        ]), false);

        $this->assertTrue($player->refresh()->getMarketValue() !== 100);

        $this->assertDatabaseHas(
            $transfer->getTable(),
            [
                'id'   => $transfer->getId(),
                'type' => TransferTypes::SOLD->value,
            ]
        );

        $this->assertDatabaseHas(
            $buyerTeam->getTable(),
            [
                'id'      => $buyerTeam->getId(),
                'balance' => 90,
            ]
        );

        $this->assertDatabaseHas(
            $team->getTable(),
            [
                'id'      => $team->getId(),
                'balance' => 10,
            ]
        );
    }
}
