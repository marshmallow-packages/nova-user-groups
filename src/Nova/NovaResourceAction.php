<?php

namespace Marshmallow\NovaUserGroups\Nova;

use App\Nova\Resource;
use Eminiarts\Tabs\TabsOnEdit;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Marshmallow\NovaUserGroups\NovaUserGroups;
use Marshmallow\Translatable\Facades\TranslatableTabs;
use Marshmallow\Translatable\Traits\TranslatableFields;

class NovaResourceAction extends Resource
{
    use TabsOnEdit;
    use TranslatableFields;

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

    public function translatableFieldsEnabled()
    {
        return true;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request Request
     *
     * @return array
     */
    public function translatableFields(Request $request)
    {
        return [
            TranslatableTabs::make($this, __('Resource action'), [
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

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
