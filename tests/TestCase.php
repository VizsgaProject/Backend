<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    // Add any shared setup or functionality for your tests here

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh', ['--env' => 'testing']);

        $this->artisan('db:seed', ['--env' => 'testing']);

    }
}
