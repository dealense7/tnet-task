<?php

declare(strict_types=1);

namespace Tests\Feature\Country;

use App\Libraries\Testing\ProvideTestingData;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\TestCase;

class ListTest extends TestCase
{
    #[Test()]
    public function it_should_raise_unauthenticated(): void
    {
        $response = $this->jsonWithHeader('GET', $this->url('countries'));

        $response->assertUnauthorized();
    }

    #[Test()]
    public function it_should_return_country_list(): void
    {
        ProvideTestingData::createRandomUserAndAuthorize();
        ProvideTestingData::createCountryRandomItems([], 3);

        $response = $this->jsonWithHeader('GET', $this->url('countries'));

        $response->assertOk();
        $response->assertJsonDataCollectionStructure($this->countryStructure(), false);
    }
}
