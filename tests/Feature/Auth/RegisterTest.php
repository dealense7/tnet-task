<?php

declare(strict_types = 1);

namespace Tests\Feature\Auth;

use App\Libraries\Testing\ProvideTestingData;
use App\Models\Team;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\TestCase;

class RegisterTest extends TestCase
{
    #[Test()]
    public function it_should_raise_validation_error(): void
    {
        $response = $this->jsonWithHeader('POST', $this->url('auth/register'));
        $response->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    #[Test()]
    public function it_should_raise_error_for_wrong_data(): void
    {
        $data = [
            'name'     => 'wrong@test.com',
            'email'    => 'user@test.com',
            'password' => 'password',
        ];
        $response = $this->jsonWithHeader('POST', $this->url('auth/register'), $data);
        $response->assertJsonValidationErrors(['password']);
    }

    #[Test()]
    public function it_should_raise_error_for_unique_email(): void
    {
        ProvideTestingData::createUserRandomItems([
            'email'    => 'user@test.com',
            'password' => 'password',
        ], 1)->first();
        $data = [
            'name'                  => 'wrong@test.com',
            'email'                 => 'user@test.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ];
        $response = $this->jsonWithHeader('POST', $this->url('auth/register'), $data);
        $response->assertJsonValidationErrors(['email']);
    }

    #[Test()]
    public function it_should_return_token(): void
    {
        $data = [
            'name'                  => 'wrong@test.com',
            'email'                 => 'user@test.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ];


        $this->assertDatabaseMissing(
            (new User())->getTable(),
            [
                'email' => 'user@test.com',
            ]
        );

        $response = $this->jsonWithHeader('POST', $this->url('auth/register'), $data);

        // User is created
        $this->assertDatabaseHas(
            (new User())->getTable(),
            [
                'email' => 'user@test.com',
            ]
        );

        // User has a Team
        $this->assertDatabaseHas(
            (new Team())->getTable(),
            [
                'user_id' => (new User())->firstWhere('email', 'user@test.com')->getId(),
            ]
        );

        $response->assertOk();
        $response->assertJsonDataItemStructure($this->tokenStructure());
    }
}
