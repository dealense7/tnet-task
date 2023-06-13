<?php

declare(strict_types = 1);

namespace Tests\Feature\Transfer;

use App\Libraries\Testing\ProvideTestingData;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\TestCase;

class ListTest extends TestCase
{
    #[Test()]
    public function it_should_raise_unauthenticated(): void
    {
        $response = $this->jsonWithHeader('GET', $this->url('transfers'));

        $response->assertUnauthorized();
    }

    #[Test()]
    public function it_should_return_country_list(): void
    {
        ProvideTestingData::createRandomUserAndAuthorize();

        $user = ProvideTestingData::createUserRandomItems([], 1)->first();
        $team = ProvideTestingData::createTeamRandomItems([
            'user_id' => $user->getId(),
        ], 1)->first();
        $player = ProvideTestingData::createPlayerRandomItems([
            'team_id'      => $team->getId(),
        ], 1)->first();

        ProvideTestingData::createTransferRandomItems([
            'player_id' => $player,
        ], 1)->first();

        $response = $this->jsonWithHeader('GET', $this->url('transfers'));

        $response->assertOk();
        $response->assertJsonDataCollectionStructure($this->transferStructure(), false);
    }
}
