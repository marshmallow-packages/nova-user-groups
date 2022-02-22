<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Allowed Admin Groups
    |--------------------------------------------------------------------------
    |
    | This is a list of groups on which the methods will be defined.
    |
    */
    'groups' => [
        'admin' => 'Administrator',
        'super-admin' => 'SuperAdministrator',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default groups
    |--------------------------------------------------------------------------
    |
    | Add an array with the id's of the user groups you want to be connected to
    | newly added user in Nova. Please not that they will only be connected if
    | the user is created in Nova. The array could look like the example below:
    |
    | 'default_groups' => [1,5,20],
    |
    */
    'default_groups' => null,

    /*
    |--------------------------------------------------------------------------
    | Allowed Methods
    |--------------------------------------------------------------------------
    |
    | This is a list of allowed methods per group
    |
    */
    'methods' => [
        'admin' => [
            'viewNova',
        ],
        'super-admin' => [
            'viewNova',
            'viewTelescope',
            'viewHorizon'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | User model methods
    |--------------------------------------------------------------------------
    |
    | Add simple methods to a group to check if they are allowed to do something.
    |
    */
    'user_methods' => [
        'viewNova' => 'View the backoffice',
        'viewTelescope' => 'View logs',
        'viewHorizon' => 'View queues',
    ],
];
