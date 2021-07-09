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

        foreach ($this->groups()->active()->get() as $group) {
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
