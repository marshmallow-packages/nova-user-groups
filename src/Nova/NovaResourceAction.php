<?php

namespace Marshmallow\NovaUserGroups\Nova;

use App\Nova\Resource;
use Eminiarts\Tabs\Tabs;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Eminiarts\Tabs\Traits\HasTabs;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsTo;
use Marshmallow\NovaUserGroups\NovaUserGroups;

class NovaResourceAction extends Resource
{
    use HasTabs;

    public static $priority = 30;

    public static $group = 'User groups';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Marshmallow\NovaUserGroups\Models\NovaResourceAction';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    public static function label()
    {
        return __('Resource Action');
    }

    public static function singularLabel()
    {
        return __('Resource Actions');
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
            Tabs::make(__('Resource action'), [
                'Main' => [
                    ID::make(__('ID')),
                    BelongsTo::make(__('Resource'), 'resource', NovaUserGroups::$novaResource)->rules(['required'])->required(),
                    Text::make(__('Name'), 'name')->sortable()->rules(['required'])->required(),
                    Text::make(__('Description'), 'description')->sortable()->rules(['required'])->required(),
                    Boolean::make(__('Active'), 'active'),
                ],
            ])->withToolbar(),
        ];
    }
}
