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

    public static $group_icon = '<svg xmlns="http://www.w3.org/2000/svg" class="sidebar-icon" enable-background="new 0 0 24 24" height="24" viewBox="0 0 24 24" width="24"><rect fill="none" height="24" width="24"/><g><path fill="var(--sidebar-icon)" d="M12,12.75c1.63,0,3.07,0.39,4.24,0.9c1.08,0.48,1.76,1.56,1.76,2.73L18,18H6l0-1.61c0-1.18,0.68-2.26,1.76-2.73 C8.93,13.14,10.37,12.75,12,12.75z M4,13c1.1,0,2-0.9,2-2c0-1.1-0.9-2-2-2s-2,0.9-2,2C2,12.1,2.9,13,4,13z M5.13,14.1 C4.76,14.04,4.39,14,4,14c-0.99,0-1.93,0.21-2.78,0.58C0.48,14.9,0,15.62,0,16.43V18l4.5,0v-1.61C4.5,15.56,4.73,14.78,5.13,14.1z M20,13c1.1,0,2-0.9,2-2c0-1.1-0.9-2-2-2s-2,0.9-2,2C18,12.1,18.9,13,20,13z M24,16.43c0-0.81-0.48-1.53-1.22-1.85 C21.93,14.21,20.99,14,20,14c-0.39,0-0.76,0.04-1.13,0.1c0.4,0.68,0.63,1.46,0.63,2.29V18l4.5,0V16.43z M12,6c1.66,0,3,1.34,3,3 c0,1.66-1.34,3-3,3s-3-1.34-3-3C9,7.34,10.34,6,12,6z"/></g></svg>';

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
                BelongsToMany::make(__('Resources'), 'resources', NovaUserGroups::$novaResource)->fields(function () {
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
                BelongsToMany::make(__('Tools'), 'tools', NovaUserGroups::$novaTool)->fields(function () {
                    return [
                        Boolean::make(__('Active for group'), 'active'),
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
