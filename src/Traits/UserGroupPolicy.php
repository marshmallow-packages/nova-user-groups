<?php

namespace Marshmallow\NovaUserGroups\Traits;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

trait UserGroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->may('viewAny', $this->getResourceName());
    }

    public function __call($method, $arguments)
    {
        return request()->user()->may($method, $this->getResourceName(), $arguments);
    }

    protected function getResourceName()
    {
        $policy_class = get_class($this);
        $policy_class_parts = explode("\\", $policy_class);
        $policy_name = array_pop($policy_class_parts);

        return str_replace('Policy', '', $policy_name);
    }
}
