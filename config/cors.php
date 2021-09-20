<?php

return [
    /**
     * Configuração do Cross-Origin Resource Sharing (CORS)
     * Aqui estão as configurações para o cross-origin resource sharing, ou "CORS". Aqui são determinadas as operações
     * de cross-origin que serão executadas pelos navegadores web.
     *
     * Informações adicionais: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
     */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,
];
