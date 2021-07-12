<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Allowed Methods
    |--------------------------------------------------------------------------
    |
    | This is a list of methods the toolbar will not run on.
    |
    */
    'groups' => [
        'admin' => 'Administrator',
        'super-admin' => 'SuperAdministrator',
    ],
    'methods' => [
        'admin' => [
            'viewNova',
            'viewTelescope',
            'viewHorizon'
        ],
        'super-admin' => [
            'viewTelescope',
            'viewHorizon'
        ]
    ],
];
