<?php

return [
    /**
     * Não será utilizado Queue nesta aplicação.
     * Esta é a configuração padrão do framework.
     */

    'default' => 'sync',

    'connections' => [
        'sync' => [
            'driver' => 'sync',
        ],
    ],

    'failed' => [
        'driver' => 'database-uuids',
        'database' => 'mysql',
        'table' => 'failed_jobs',
    ],
];
