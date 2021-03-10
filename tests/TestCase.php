<?php

declare(strict_types=1);

namespace Asseco\PlanRouter\Tests;

use Asseco\PlanRouter\PlanRouterServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [PlanRouterServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }
}
