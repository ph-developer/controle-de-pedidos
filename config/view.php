<?php

return [
    /**
     * Locais de Armazenamento das Views
     * Locais que serão percorridos em busca de views na aplicação.
     */
    'paths' => [
        resource_path('views'),
    ],

    /**
     * Local de Armazenamento das Views Compiladas
     * Local que serão armazenados os templates Blade das views da aplicação
     */
    'compiled' => realpath(storage_path('framework/views')),
];
