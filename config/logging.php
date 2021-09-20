<?php

return [
    /**
     * Não será utilizado sistema de logging personalizado nesta aplicação.
     * Esta é a configuração padrão do framework.
     */

    'default' => 'stack',

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
            'ignore_exceptions' => false,
        ],
    ],
];
