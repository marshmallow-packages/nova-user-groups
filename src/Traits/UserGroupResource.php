<?php

namespace Marshmallow\NovaUserGroups\Traits;

use Illuminate\Http\Request;
use Marshmallow\NovaUserGroups\NovaUserGroupsFacade;

trait UserGroupResource
{
    public static function availableForNavigation(Request $request)
    {
        $resource = NovaUserGroupsFacade::getNovaResourceName(get_called_class());
        return $request->user()->may('showInMenu', $resource);
    }
}
