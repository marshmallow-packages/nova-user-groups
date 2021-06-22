<?php

namespace Marshmallow\NovaUserGroups;

use Illuminate\Support\Facades\Facade;
use Marshmallow\NovaUserGroups\NovaUserGroups;

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
