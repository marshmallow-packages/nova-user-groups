<?php

namespace Marshmallow\NovaUserGroups\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Marshmallow\NovaUserGroups\NovaUserGroups;

class NovaResource extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public static $default_actions = [
        'showInMenu' => 'Show this resource in the menu.',
        'viewAny' => 'Users can view any of these models.',
        'view' => 'Users can view the details of these models.',
        'create' => 'Users can create these models.',
        'update' => 'Users can update these models.',
        'delete' => 'Users can delete these models.',
        'restore' => 'Users can restore these models.',
        'forceDelete' => 'Users can permanently delete these models.',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($resource) {
            $resource->createDefaultActions();
        });

        static::updated(function ($resource) {
            $resource->createDefaultActions();
        });
    }

    public function createDefaultActions()
    {
        foreach (self::$default_actions as $action => $description) {
            NovaUserGroups::$novaResourceActionModel::updateOrCreate([
                'nova_resource_id' => $this->id,
                'name' => $action,
                'description' => $description,
            ]);
        }
    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('active', true);
    }

    public function groups()
    {
        return $this->belongsToMany(NovaUserGroups::$userGroupModel)->withPivot(['policy']);
    }

    public function actions()
    {
        return $this->hasMany(NovaUserGroups::$novaResourceActionModel, 'nova_resource_id');
    }
}
