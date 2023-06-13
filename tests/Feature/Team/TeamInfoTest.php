<?php

declare(strict_types = 1);

namespace Tests\Feature\Team;

use App\Libraries\Testing\ProvideTestingData;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\TestCase;

class TeamInfoTest extends TestCase
{
    #[Test()]
    public function it_should_raise_unauthenticated(): void
    {
        $response = $this->jsonWithHeader('GET', $this->url('team'));

        $response->assertUnauthorized();
    }

    #[Test()]
    public function it_should_return_not_found_if_user_has_no_team(): void
    {
        ProvideTestingData::createRandomUserAndAuthorize();

        $response = $this->jsonWithHeader('GET', $this->url('team'));
        $response->assertNotFound();
    }

    #[Test()]
    public function it_should_return_team_info(): void
    {
        $user = ProvideTestingData::createRandomUserAndAuthorize();

        /** @var \App\Models\Team $team */
        $team = ProvideTestingData::createTeamRandomItems([
            'user_id' => $user->getId(),
        ], 1)->first();

        ProvideTestingData::createPlayerRandomItems([
            'team_id' => $team->getId(),
        ], 3);

        $response = $this->jsonWithHeader('GET', $this->url('team'));

        $response->assertOk();
        $response->assertJsonDataItemStructure($this->teamStructure([
            '[players:player]',
        ]));
    }
}
