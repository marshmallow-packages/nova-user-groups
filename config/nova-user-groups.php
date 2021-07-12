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
];
