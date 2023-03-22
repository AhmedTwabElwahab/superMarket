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
            'user'              => 'c,r,u,d',
            'client'            => 'c,r,u,d',
            'supplier'          => 'c,r,u,d',
            'category'          => 'c,r,u,d',
            'saleinvoice'       => 'c,r,u,d',
            'salereturn'        => 'c,r,u,d',
            'purchaseinvoice'   => 'c,r,u,d',
            'purchasereturn'    => 'c,r,u,d',
            'warehouse'         => 'c,r,u,d',
            'receipt'           => 'c,r,u,d',
            'setting'           => 'c,r,u,d',
            'profile'           => 'c,r,u,d',
            'product'           => 'c,r,u,d',
            'journal'           => 'c,r,u,d',
            'store'             => 'c,r,u,d',
            'account'           => 'c,r,u,d',
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
