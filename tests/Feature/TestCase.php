<?php

namespace Tests\Feature;

use App\Libraries\Testing\Response;
use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{

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
