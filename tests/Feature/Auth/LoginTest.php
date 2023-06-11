<?php

namespace Tests\Feature\Auth;

use App\Libraries\Testing\ProvideTestingData;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\TestCase;

class LoginTest extends TestCase
{
    #[Test()]
    public function it_should_raise_validation_error(): void
    {
        $response = $this->jsonWithHeader('POST', $this->url('auth/login'));
        $response->assertJsonValidationErrors(['email', 'password']);
    }

    #[Test()]
    public function it_should_raise_error_for_wrong_data(): void
    {
        ProvideTestingData::createUserRandomItems([
            'email' => 'user@test.com'
        ], 1)->first();
        $data = [
            'email' => 'wrong@test.com',
            'password' => 'password',
        ];
        $response = $this->jsonWithHeader('POST', $this->url('auth/login'), $data);
        $response->assertJsonValidationErrors(['email']);
    }

    #[Test()]
    public function it_should_raise_error_for_wrong_password(): void
    {
        ProvideTestingData::createUserRandomItems([
            'email' => 'user@test.com',
            'password' => 'password'
        ], 1)->first();
        $data = [
            'email' => 'user@test.com',
            'password' => 'wrong',
        ];
        $response = $this->jsonWithHeader('POST', $this->url('auth/login'), $data);
        $response->assertJsonValidationErrors(['email']);
    }

    #[Test()]
    public function it_should_return_token(): void
    {
        ProvideTestingData::createUserRandomItems([
            'email' => 'user@test.com',
            'password' => 'password'
        ], 1)->first();
        $data = [
            'email' => 'user@test.com',
            'password' => 'password',
        ];
        $response = $this->jsonWithHeader('POST', $this->url('auth/login'), $data);
        $response->assertOk();
        $response->assertJsonDataItemStructure($this->tokenStructure());
    }
}
