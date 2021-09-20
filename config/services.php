<?php

return [
    /**
     * Não será utilizado nenhum serviço de terceiros nesta aplicação.
     * Esta é a configuração padrão do framework.
     */

    'mailgun' => [
        'domain' => null,
        'secret' => null,
        'endpoint' => null,
    ],

    'postmark' => [
        'token' => null,
    ],

    'ses' => [
        'key' => null,
        'secret' => null,
        'region' => null,
    ],
];
