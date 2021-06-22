<?php

namespace Marshmallow\NovaUserGroups\Commands;

use Illuminate\Console\Command;
use Marshmallow\NovaUserGroups\NovaUserGroupsFacade;

class ImportResourcesCommand extends Command
{
    public $signature = 'user-groups:import-resources';

    public $description = 'Create missing resources in the database from the app/Nova folder';

    public function handle()
    {
        NovaUserGroupsFacade::importResources();
    }
}
