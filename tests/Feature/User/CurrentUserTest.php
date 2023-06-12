<?php

declare(strict_types = 1);

namespace Tests\Feature\User;

use App\Libraries\Testing\ProvideTestingData;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\TestCase;

class CurrentUserTest extends TestCase
{
    #[Test()]
    public function it_should_raise_unauthenticated(): void
    {
        $response = $this->jsonWithHeader('GET', $this->url('user'));

        $response->assertUnauthorized();
    }

    #[Test()]
    public function it_should_return_user(): void
    {
        ProvideTestingData::createRandomUserAndAuthorize();

        $response = $this->jsonWithHeader('GET', $this->url('user'));

        $response->assertOk();
        $response->assertJsonDataItemStructure($this->userStructure());
    }
}
