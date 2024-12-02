<?php

namespace Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \VenipakSDK\VenipakServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('venipak.base_url', 'https://api.venipak.com');
        $app['config']->set('venipak.api_key', 'test_api_key');
    }
}