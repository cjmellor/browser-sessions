<?php

namespace Cjmellor\BrowserSessions\Tests;

use Cjmellor\BrowserSessions\BrowserSessionsServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Cjmellor\\BrowserSessions\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            BrowserSessionsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        // $migration = include __DIR__.'/../database/migrations/MIGRATION.php';
        // $migration->up();
    }
}
