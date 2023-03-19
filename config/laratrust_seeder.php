<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'super_admin' =>
            [
            'user'       => 'c,r,u,d',
            'product'    => 'c,r,u,d',
            'client'     => 'c,r,u,d',
            'supplier'   => 'c,r,u,d',
            'category'   => 'c,r,u,d',
            'receipt'    => 'c,r,d',
            'expense'    => 'c,r,d',
            'store'      => 'r',
        ],
        'user' => [],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
