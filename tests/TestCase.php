<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function routeGet($routeName, array $headers = []): TestResponse
    {
        return $this->get($routeName, $headers);
    }
}
