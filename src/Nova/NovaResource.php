<?php

namespace Marshmallow\NovaUserGroups\Nova;

use App\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Eminiarts\Tabs\TabsOnEdit;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BooleanGroup;
use Laravel\Nova\Fields\BelongsToMany;
use Marshmallow\NovaUserGroups\NovaUserGroups;
use Marshmallow\Translatable\Facades\TranslatableTabs;
use Marshmallow\Translatable\Traits\TranslatableFields;

class NovaResource extends Resource
{
    use TabsOnEdit;
    use TranslatableFields;

    public static $priority = 20;

    public static $group = 'User groups';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Marshmallow\NovaUserGroups\Models\NovaResource';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    public static function label()
    {
        return __('Resource');
    }

    public static function singularLabel()
    {
        return __('Resources');
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
            TranslatableTabs::make($this, __('Resources'), [
                'Main' => [
                    ID::make(__('ID')),
                    Text::make(__('Name'), 'name')->sortable()->rules(['required']),
                    Boolean::make(__('Active'), 'active'),
                ],

                HasMany::make(__('Actions'), 'actions', NovaUserGroups::$novaResourceAction),
                BelongsToMany::make(__('User groups'), 'groups', NovaUserGroups::$novaUserGroup)->fields(function ($indexRequest, $novaResource) {

                    return [
                        BooleanGroup::make(__('Policy'), 'policy')->options(
                            $novaResource->actions->booleanGroupArray()
                        )->resolveUsing(function ($value, $pivot, $column) {
                            return json_decode($pivot->policy);
                        })->hideWhenCreating(),
                    ];
                }),
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
