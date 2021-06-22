<?php

namespace Marshmallow\NovaUserGroups\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Marshmallow\NovaUserGroups\NovaUserGroups;
use Marshmallow\NovaUserGroups\Collections\NovaResourceActionCollection;

class NovaResourceAction extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function resource()
    {
        return $this->belongsTo(NovaUserGroups::$novaResourceModel, 'nova_resource_id');
    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('active', true);
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new NovaResourceActionCollection($models);
    }
}
