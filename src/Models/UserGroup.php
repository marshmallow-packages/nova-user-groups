<?php

namespace Marshmallow\NovaUserGroups\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Marshmallow\NovaUserGroups\NovaUserGroups;
use Marshmallow\Translatable\Traits\Translatable;

class UserGroup extends Model
{
    use SoftDeletes;
    use Translatable;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($created_resource) {
            $created_resource->attachAllMissingResources();
        });
    }

    public function attachAllMissingResources()
    {
        $resources = NovaUserGroups::$novaResourceModel::get();
        $resources->each(function ($resource) {
            if (! $this->resources->contains($resource->id)) {
                $this->resources()->attach($resource, [
                    'policy' => $resource->actions->booleanGroupDefaultSettings(),
                ]);
            }
        });
    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('active', true);
    }

    public function users()
    {
        return $this->belongsToMany(NovaUserGroups::$userModel);
    }

    public function resources()
    {
        return $this->belongsToMany(NovaUserGroups::$novaResourceModel)->withPivot(['policy']);
    }
}
