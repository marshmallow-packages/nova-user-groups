<?php

namespace Marshmallow\NovaUserGroups;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Marshmallow\NovaUserGroups\Commands\GeneratePolicyCommand;
use Marshmallow\NovaUserGroups\Commands\ImportResourcesCommand;
use Marshmallow\NovaUserGroups\Commands\GeneratePoliciesCommand;
use Marshmallow\NovaUserGroups\Commands\InstallAdminGroupCommand;

class NovaUserGroupsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('nova-user-groups')
            ->hasConfigFile()
            ->hasMigration('create_user_groups_table')
            ->hasMigration('create_nova_tools_table')
            ->hasMigration('add_methods_to_user_groups_table')
            ->hasCommand(GeneratePolicyCommand::class)
            ->hasCommand(ImportResourcesCommand::class)
            ->hasCommand(GeneratePoliciesCommand::class)
            ->hasCommand(InstallAdminGroupCommand::class);
    }
}
