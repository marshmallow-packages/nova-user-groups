<?php

namespace Marshmallow\NovaUserGroups;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Marshmallow\NovaUserGroups\NovaUserGroups
 */
class NovaUserGroupsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return NovaUserGroups::class;
    }
}
