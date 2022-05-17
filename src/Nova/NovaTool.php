<?php

namespace Marshmallow\NovaUserGroups\Nova;

use App\Nova\Resource;
use Eminiarts\Tabs\Tabs;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Eminiarts\Tabs\Traits\HasTabs;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BooleanGroup;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Http\Requests\NovaRequest;
use Marshmallow\NovaUserGroups\NovaUserGroups;

class NovaTool extends Resource
{
    use HasTabs;

    public static $priority = 20;

    public static $group = 'User groups';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Marshmallow\NovaUserGroups\Models\NovaTool';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    public static function label()
    {
        return __('Tools');
    }

    public static function singularLabel()
    {
        return __('Tool');
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Tabs::make(__('Resources'), [
                'Main' => [
                    ID::make(__('ID')),
                    Text::make(__('Name'), 'name')->sortable()->rules(['required']),
                    Boolean::make(__('Active'), 'active'),
                ],
                BelongsToMany::make(__('User groups'), 'groups', NovaUserGroups::$novaUserGroup)->fields(function () {
                    return [
                        Boolean::make(__('Active for group'), 'active')
                    ];
                }),
            ])->withToolbar(),
        ];
    }
}
