<?php

namespace Marshmallow\NovaUserGroups\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Marshmallow\NovaUserGroups\NovaUserGroups;

class NovaTool extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function scopeActive(Builder $builder)
    {
        $builder->where('nova_tools.active', true);
    }

    public function groups()
    {
        return $this->belongsToMany(NovaUserGroups::$userGroupModel)->withPivot(['active']);
    }
}
