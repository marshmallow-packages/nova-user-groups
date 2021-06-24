<?php

namespace Marshmallow\NovaUserGroups;

use Marshmallow\NovaUserGroups\Commands\GeneratePoliciesCommand;
use Marshmallow\NovaUserGroups\Commands\GeneratePolicyCommand;
use Marshmallow\NovaUserGroups\Commands\ImportResourcesCommand;
use Marshmallow\NovaUserGroups\Commands\InstallAdminGroupCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class NovaUserGroupsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('nova-user-groups')
            ->hasConfigFile()
            ->hasMigration('create_user_groups_table')
            ->hasCommand(GeneratePolicyCommand::class)
            ->hasCommand(ImportResourcesCommand::class)
            ->hasCommand(GeneratePoliciesCommand::class)
            ->hasCommand(InstallAdminGroupCommand::class);
    }
}
