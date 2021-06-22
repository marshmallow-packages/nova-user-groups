<?php

namespace Marshmallow\NovaUserGroups\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Marshmallow\NovaUserGroups\NovaUserGroupsFacade;

class InstallAdminGroupCommand extends Command
{
    public $signature = 'user-groups:install';

    public $description = 'This command will generate every Nova Resource and an user group for administrators. It will also connect the existing users to this new administrator group';

    public function handle()
    {
        Artisan::call('marshmallow:resource UserGroup NovaUserGroups --force');
        Artisan::call('marshmallow:resource NovaResource NovaUserGroups --force');
        Artisan::call('marshmallow:resource NovaResourceAction NovaUserGroups --force');
        NovaUserGroupsFacade::importResources();
        NovaUserGroupsFacade::generateAdministratorGroup();
    }
}
