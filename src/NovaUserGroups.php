<?php

namespace Marshmallow\NovaUserGroups;

use Illuminate\Support\Str;

class NovaUserGroups
{
    public static $userModel = \App\Models\User::class;
    public static $userGroupModel = \Marshmallow\NovaUserGroups\Models\UserGroup::class;
    public static $novaResourceModel = \Marshmallow\NovaUserGroups\Models\NovaResource::class;
    public static $novaResourceActionModel = \Marshmallow\NovaUserGroups\Models\NovaResourceAction::class;

    public static $userResource = \App\Nova\User::class;
    public static $novaUserGroup = \Marshmallow\NovaUserGroups\Nova\UserGroup::class;
    public static $novaResource = \Marshmallow\NovaUserGroups\Nova\NovaResource::class;
    public static $novaResourceAction = \Marshmallow\NovaUserGroups\Nova\NovaResourceAction::class;

    public function generateAdministratorGroup()
    {
        $group = self::$userGroupModel::where('name', 'Administrator')->first();
        if (!$group) {
            $group = self::$userGroupModel::create([
                'name' => 'Administrator',
            ]);
        }

        self::$userModel::get()->each(function ($user) use ($group) {
            if (!method_exists($user, 'isAdmin') || $user->isAdmin()) {
                if (!$group->users->contains($user->id)) {
                    $group->users()->attach($user);
                }
            }
        });
    }

    public function importResources()
    {
        $resources = $this->getNovaResources();
        foreach ($resources as $resource) {
            self::$novaResourceModel::updateOrCreate([
                'name' => $resource,
            ])->createDefaultActions();
        }
    }

    public function getNovaResources()
    {
        $resources = [];
        $nova_path = app_path("Nova/*.php");
        foreach (glob($nova_path) as $file) {
            $file_parts = explode("/", $file);
            $file_name = Str::of(array_pop($file_parts))->replace('.php', '');
            $resources[] = (string) $file_name;
        }

        return $resources;
    }

    public function getNovaResourceName(string $resource_class_name)
    {
        $file_parts = explode("\\", $resource_class_name);
        $resource_name = array_pop($file_parts);
        return $resource_name;
    }

    public function getNovaResource(string $resource_class_name)
    {
        $resource_name = $this->getNovaResourceName($resource_class_name);
        return self::$novaResourceModel::where('name', $resource_name)->first();
    }
}
