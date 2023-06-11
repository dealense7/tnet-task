<?php

declare(strict_types = 1);

namespace Tests\Feature;

use App\Libraries\Testing\ProvideDataStructures;
use App\Libraries\Testing\Response;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use DatabaseTransactions;
    use ProvideDataStructures;

    public function jsonWithHeader($method, $uri, array $data = [], array $headers = []): Response
    {
        $response = parent::json($method, $uri, $data, $headers);
        return new Response($response->baseResponse);
    }

    protected function url(string $url, string $version = 'v1'): string
    {
        return 'api/' . $version . '/' . $url;
    }
}
