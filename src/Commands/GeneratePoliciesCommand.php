<?php

namespace Marshmallow\NovaUserGroups\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Marshmallow\NovaUserGroups\NovaUserGroupsFacade;

class GeneratePoliciesCommand extends Command
{
    public $signature = 'user-groups:policies';

    public $description = 'This command will generate policies for every nova resource in you Nova folder';

    public function handle()
    {
        $policies = [];
        $resources = NovaUserGroupsFacade::getNovaResources();
        foreach ($resources as $resource) {

            $nova_resource_class = "\\App\\Nova\\{$resource}";
            $policy_namespaced = "\\App\\Policies\\{$resource}Policy";
            if (isset($nova_resource_class::$model)) {
                $model_namespaced = "\\" . $nova_resource_class::$model;

                Artisan::call("user-groups:policy {$resource}Policy");
                $policies[$model_namespaced] = $policy_namespaced;
            }
        }

        $this->info('protected $policies = [');
        foreach ($policies as $model_namespaced => $policy_namespaced) {
            $this->info("\t{$model_namespaced}::class => {$policy_namespaced}::class,");
        }
        $this->info('];');

        $this->newLine();
        $this->newLine();
        $this->info('Add the policies to your "AuthServiceProvider"');
    }
}
