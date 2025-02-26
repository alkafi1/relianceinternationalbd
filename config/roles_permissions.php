<?php

return [
    'roles' => [
        'super_admin' => [
            'permissions' => [
                '*' => ['*'], // Wildcard to grant all permissions
            ],
        ],
        'admin' => [
            'permissions' => [
                'posts' => ['create', 'edit', 'delete', 'view'],
                'users' => ['create', 'edit', 'delete', 'view'],
                'settings' => ['edit'],
            ],
        ],
        'editor' => [
            'permissions' => [
                'posts' => ['create', 'edit', 'view'],
                'users' => ['view'],
            ],
        ],
        'user' => [
            'permissions' => [
                'posts' => ['create', 'view'],
            ],
        ],
    ],
];