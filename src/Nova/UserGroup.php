<?php

namespace Marshmallow\NovaUserGroups\Nova;

use App\Nova\Resource;
use Eminiarts\Tabs\Tabs;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Eminiarts\Tabs\TabsOnEdit;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BooleanGroup;
use Laravel\Nova\Fields\BelongsToMany;
use Marshmallow\NovaUserGroups\NovaUserGroups;
use Marshmallow\NovaUserGroups\Nova\Actions\AttachAllMissingResources;

class UserGroup extends Resource
{
    use TabsOnEdit;

    public static $group = 'User groups';

    public static $priority = 10;

    public static $group_icon = '<svg xmlns="http://www.w3.org/2000/svg" class="sidebar-icon" enable-background="new 0 0 20 20" height="20" viewBox="0 0 20 20" width="20"><g><rect fill="none" height="20" width="20"/></g><g><path fill="var(--sidebar-icon)" d="M16,6h-4V4c0-0.55-0.45-1-1-1H9C8.45,3,8,3.45,8,4v2H4C3.45,6,3,6.45,3,7v9c0,0.55,0.45,1,1,1h12c0.55,0,1-0.45,1-1V7 C17,6.45,16.55,6,16,6z M9,4h2v4H9V4z M8,10c0.55,0,1,0.45,1,1s-0.45,1-1,1s-1-0.45-1-1S7.45,10,8,10z M10,14H6v-0.5 c0-0.67,1.33-1,2-1s2,0.33,2,1V14z M14,13h-3v-1h3V13z M14,11h-3v-1h3V11z"/></g></svg>';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Marshmallow\NovaUserGroups\Models\UserGroup';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    public static function label()
    {
        return __('User group');
    }

    public static function singularLabel()
    {
        return __('User groups');
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
    public function fields(Request $request)
    {
        return [
            Tabs::make(__('User groups'), [
                'Main' => [
                    ID::make(__('ID')),
                    Text::make(__('Name'), 'name')->sortable()->rules(['required']),
                    Boolean::make(__('Active'), 'active'),
                ],
                BelongsToMany::make(__('Users'), 'users', NovaUserGroups::$userResource),
                BelongsToMany::make(__('Resources'), 'resources', NovaUserGroups::$novaResource)->fields(function ($indexRequest, $test) {
                    $options = [];
                    if (request()->relatedResourceId) {
                        $model = NovaUserGroups::$novaResourceModel::find(request()->relatedResourceId);
                        if ($model) {
                            $options = $model->actions->booleanGroupArray();
                        }
                    } else {
                        $model = NovaUserGroups::$novaResourceModel::find(request()->viaResourceId);
                        if ($model) {
                            $options = $model->actions->booleanGroupArray();
                        }
                    }

                    return [
                        BooleanGroup::make(__('Policy'), 'policy')->options($options)->resolveUsing(function ($value, $pivot, $column) {
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
        return [
            new AttachAllMissingResources,
        ];
    }
}
