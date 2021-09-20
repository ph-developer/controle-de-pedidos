<?php

use Illuminate\Support\Str;

return [
    /**
     * Não será utilizado nenhum sistema de cache personalizado nesta aplicação devido ao seu tamanho.
     * Utilizaremos o próprio sistema de arquivos para cache.
     * Esta é a configuração padrão do framework.
     */

    'default' => 'file',

    'stores' => [
        'file' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/data'),
        ],
    ],

    'prefix' => Str::slug('Controle de Pedidos', '_') . '_cache',
];
