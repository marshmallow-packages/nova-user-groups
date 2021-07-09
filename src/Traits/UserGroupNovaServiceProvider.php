<?php

namespace Marshmallow\NovaUserGroups\Traits;

use Illuminate\Support\Facades\Auth;


trait UserGroupNovaServiceProvider
{
    public function canSeeCards(array $cards)
    {
        return $cards;
    }

    public function canSeeDashboards(array $dashboards)
    {
        return $dashboards;
    }

    public function canSeeTools(array $tools)
    {
        $return_tools = [];
        foreach ($tools as $tool) {
            $return_tools[] = $tool->canSee(function () use ($tool) {
                return Auth::user()->maySeeTool($tool);
            });
        }
        return $return_tools;
    }
}
