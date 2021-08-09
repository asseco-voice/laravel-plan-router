<?php

declare(strict_types=1);

namespace Asseco\PlanRouter\Tests;

use Asseco\Common\CommonServiceProvider;
use Asseco\PlanRouter\PlanRouterServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->runLaravelMigrations();
    }

    protected function getPackageProviders($app): array
    {
        return [
            CommonServiceProvider::class,
            PlanRouterServiceProvider::class
        ];
    }
}
