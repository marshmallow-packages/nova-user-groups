<?php

namespace Marshmallow\NovaUserGroups\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Marshmallow\NovaUserGroups\NovaUserGroupsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Marshmallow\\NovaUserGroups\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            NovaUserGroupsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        include_once __DIR__.'/../database/migrations/create_nova-user-groups_table.php.stub';
        (new \CreatePackageTable())->up();
        */
    }
}
