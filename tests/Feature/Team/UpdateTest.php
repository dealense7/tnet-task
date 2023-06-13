<?php

declare(strict_types = 1);

namespace Tests\Feature\Team;

use App\Libraries\Testing\ProvideTestingData;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\TestCase;

class UpdateTest extends TestCase
{
    #[Test()]
    public function it_should_raise_unauthenticated(): void
    {
        $response = $this->jsonWithHeader('PATCH', $this->url('team/9999'));

        $response->assertUnauthorized();
    }

    #[Test()]
    public function it_should_raise_validation_error(): void
    {
        ProvideTestingData::createRandomUserAndAuthorize();

        $response = $this->jsonWithHeader('PATCH', $this->url('team/9999'));
        $response->assertJsonValidationErrors(['name']);
    }

    #[Test()]
    public function it_should_return_not_found_on_wrong_id(): void
    {
        ProvideTestingData::createRandomUserAndAuthorize();

        $data = [
            'name' => 'test',
        ];
        $response = $this->jsonWithHeader('PATCH', $this->url('team/9999'), $data);
        $response->assertNotFound();
    }

    #[Test()]
    public function it_should_raise_error_for_wrong_owner(): void
    {
        ProvideTestingData::createRandomUserAndAuthorize();

        $user = ProvideTestingData::createUserRandomItems([], 1)->first();
        $team = ProvideTestingData::createTeamRandomItems([
            'user_id' => $user->getId(),
        ], 1)->first();

        $data = [
            'name' => 'test',
        ];
        $response = $this->jsonWithHeader('PATCH', $this->url('team/' . $team->getId()), $data);
        $response->assertForbidden();
    }

    #[Test()]
    public function it_should_update_item(): void
    {
        $user = ProvideTestingData::createRandomUserAndAuthorize();

        $team = ProvideTestingData::createTeamRandomItems([
            'user_id' => $user->getId(),
            'name' => 'Old Name',
        ], 1)->first();

        $data = [
            'name' => 'New Name',
        ];
        $response = $this->jsonWithHeader('PATCH', $this->url('team/' . $team->getId()), $data);
        $response->assertOk();
        $response->assertJsonDataItemStructure($this->teamStructure());

        $this->assertDatabaseHas(
            $team->getTable(),
            [
                'id' => $team->getId(),
                'name' => 'New Name',
            ]
        );
    }
}
