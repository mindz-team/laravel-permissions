<?php

return [
    'super-admins' => explode(',', env('SUPER_ADMINS', '')),
    'permissions' => [
        //users
        ['name' => 'assign roles'],
        //roles
        ['name' => 'create roles'],
        ['name' => 'delete roles'],
        ['name' => 'update roles'],
        ['name' => 'index roles'],
        ['name' => 'show roles'],
        //permissions
        ['name' => 'index permissions'],
    ]
];
