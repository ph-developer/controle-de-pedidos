<?php

return [
    /**
     * Não será utilizado um sistema de e-mail nesta aplicação.
     * Esta é a configuração padrão do framework.
     */

    'default' => 'smtp',

    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => null,
            'port' => null,
            'encryption' => null,
            'username' => null,
            'password' => null,
            'timeout' => null,
            'auth_mode' => null,
        ],
    ],

    'from' => [
        'address' => 'admin@admin.dev',
        'name' => 'Admin',
    ],

    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],
];
