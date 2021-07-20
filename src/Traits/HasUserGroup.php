<?php

namespace Marshmallow\NovaUserGroups\Traits;

use Marshmallow\NovaUserGroups\NovaUserGroups;

trait HasUserGroup
{
    public function groups()
    {
        return $this->belongsToMany(NovaUserGroups::$userGroupModel);
    }

    public function may($method, $resource_name, $arguments = null)
    {
        if ($method == 'viewNova') {
            return true;
        }

        foreach ($this->groups as $group) {

            if (!$group->active) {
                continue;
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
}
