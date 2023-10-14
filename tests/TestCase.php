<?php

namespace Tests;

use Illuminate\Testing\TestResponse;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, 
    WithLogin;

    protected function setUp(): void
    {
        parent::setUp();
    }
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__ . '/../bootstrap/app.php';
    }

    protected function createTestResponse(): TestResponse
    {
        return TestResponse::fromBaseResponse($this->response);
    }
}
