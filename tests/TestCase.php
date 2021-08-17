<?php

namespace Tests;

use Rockbuzz\LaraUtils\ServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom([
            '--database' => 'mysql',
            '--path' => realpath(__DIR__ . '/migrations'),
        ]);

        $this->withFactories(__DIR__ . '/factories');
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'mysql');
        $app['config']->set('database.connections.mysql.host', 'dbutils');
        $app['config']->set('database.connections.mysql.database', 'testing');
        $app['config']->set('database.connections.mysql.username', 'testing');
        $app['config']->set('database.connections.mysql.password', 'secret');
    }

    protected function getPackageProviders($app): array
    {
        return [ServiceProvider::class];
    }
}
