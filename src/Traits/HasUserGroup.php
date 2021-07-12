<?php

namespace Marshmallow\NovaUserGroups\Traits;

use Illuminate\Support\Arr;
use Marshmallow\NovaUserGroups\NovaUserGroups;
use Marshmallow\NovaUserGroups\Models\UserGroup;

trait HasUserGroup
{

    public function groups()
    {
        return $this->belongsToMany(NovaUserGroups::$userGroupModel);
    }

    public function checkConfigMethod(UserGroup $group, string $method): bool
    {
        $config_group = array_keys(config('nova-user-groups.groups'), $group->name, true);
        if ($config_group = Arr::first($config_group)) {
            $configMethod = "nova-user-groups.methods.{$config_group}";
            if (in_array($method, config($configMethod))) {
                return true;
            }
        }

        return false;
    }


    public function may($method, $resource_name, $arguments = null)
    {
        foreach ($this->groups()->active()->get() as $group) {

            if ($this->checkMethod($group, $method)) {
                return true;
            }

            foreach ($group->resources()->active()->get() as $resource) {
                if ($resource->name == $resource_name) {
                    $action = $resource->actions()->active()->where('name', $method)->first();
                    if ($action) {
                        $policy = json_decode($resource->pivot->policy);
                        if (isset($policy->{$action->id})) {
                            $has_access = $policy->{$action->id};

                            return $has_access;
                        }
                    }
                }
            }
        }

        return false;
    }

    public function maySeeTool($tool_to_check)
    {
        foreach ($this->groups()->active()->get() as $group) {
            foreach ($group->tools()->active()->get() as $tool) {
                if ($tool->name == get_class($tool_to_check)) {
                    if ($tool->pivot->active) {
                        return true;
                    }
                }
            }
        }

        return false;
    }
}
