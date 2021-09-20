<?php

return [
    /**
     * Não será utilizado nenhum sistema de armazenamento de arquivos nesta aplicação.
     * Esta é a configuração padrão do framework.
     */

    'default' => 'local',

    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],
    ],

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],
];
