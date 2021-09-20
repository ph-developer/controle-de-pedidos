<?php

use Illuminate\Support\Str;

return [
    /**
     * Não será utilizado sistema de sessões personalizado nesta aplicação.
     * Esta é a configuração padrão do framework.
     */

    'driver' => 'file',

    'lifetime' => 120,

    'expire_on_close' => false,

    'encrypt' => false,

    'files' => storage_path('framework/sessions'),

    'connection' => null,

    'table' => 'sessions',

    'store' => null,

    'lottery' => [2, 100],

    'cookie' => Str::slug('Controle de Pedidos', '_') . '_session',

    'path' => '/',

    'domain' => null,

    'secure' => null,

    'http_only' => true,

    'same_site' => 'lax',
];
