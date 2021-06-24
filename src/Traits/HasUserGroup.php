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
}
