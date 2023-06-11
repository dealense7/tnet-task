<?php

namespace Tests\Feature\Auth;

use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\TestCase;

class AuthTest extends TestCase
{
    #[Test()]
    public function it_should_raise_unauthorized_on_return_items_list(): void
    {
        $response = $this->jsonWithHeader('GET', $this->url('auth/login'));
        dd($response->getDecodedContent());

        $response->assertUnauthorized();
    }
}
