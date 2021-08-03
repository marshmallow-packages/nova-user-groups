<?php

namespace Marshmallow\NovaUserGroups\Traits;

use Illuminate\Support\Arr;
use Marshmallow\HelperFunctions\Facades\URL;
use Marshmallow\NovaUserGroups\NovaUserGroups;
use Marshmallow\NovaUserGroups\Models\UserGroup;

trait HasUserGroup
{
    public static function bootHasUserGroup()
    {
        if (URL::isNova(request())) {
            static::created(function ($user) {
                $default_groups = config('nova-user-groups.default_groups');
                if (is_array($default_groups)) {
                    foreach ($default_groups as $group_id) {
                        if ($group = NovaUserGroups::$userGroupModel::find($group_id)) {
                            $user->groups()->attach($group);
                        }
                    }
                }
            });
        }
    }

    public function groups()
    {
        return $this->belongsToMany(NovaUserGroups::$userGroupModel);
    }

    public function mayViewNova()
    {
        return $this->allowedToRunMethod('viewNova');
    }

    public function mayViewTelescope()
    {
        return $this->allowedToRunMethod('viewTelescope');
    }

    public function mayViewHorizon()
    {
        return $this->allowedToRunMethod('viewHorizon');
    }

    public function allowedToRunMethod($method)
    {
        $methods = $this->getUserGroupMethods();
        return in_array($method, $methods);
    }

    public function may($method, $resource_name, $arguments = null)
    {
        $custom_method = ucfirst($method);
        $custom_method = "may{$custom_method}";

        if (method_exists($this, $custom_method)) {
            return $this->{$custom_method}();
        }

        foreach ($this->groups as $group) {

            if (!$group->active) {
                continue;
            }

            if ($this->checkConfigMethod($group, $method)) {
                return true;
            }

            foreach ($group->resources as $resource) {

                if (!$resource->active) {
                    continue;
                }

                if ($resource->name == $resource_name) {
                    $action = $resource->actions->where('name', $method)->first();

                    if ($action && $action->active) {
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


    public function maySeeTool($tool_to_check)
    {
        foreach ($this->groups as $group) {

            if (!$group->active) {
                continue;
            }

            foreach ($group->tools as $tool) {

                if (!$tool->active) {
                    continue;
                }

                if ($tool->name == get_class($tool_to_check)) {
                    if ($tool->pivot->active) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    protected function getUserGroupMethods()
    {
        $methods = [];
        foreach ($this->groups as $group) {
            foreach ($group->methods as $method => $allowed) {
                if (!$allowed) {
                    continue;
                }

                if (in_array($method, $methods)) {
                    continue;
                }

                $methods[] = $method;
            }
        }

        return $methods;
    }
}
