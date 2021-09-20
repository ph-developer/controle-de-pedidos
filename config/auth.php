<?php

return [
    /**
     * Padrões de Autenticação
     * Esta opção controla o guarda (guard) de autenticação padrão e as opções de redefinição de senha da aplicação.
     */
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /**
     * Guardas (Guards) de Autenticação
     * Aqui definimos os guardas (guards) de autenticação da aplicação.
     * Todos os drivers de autenticação têm um provedor de usuário (user provider).
     * Isto define como os usuários são resgatados do banco de dados ou outro mecanismo de armazenamento usado pela
     * aplicação para persistência de dados.
     * Drivers Suportados: "session".
     */
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    /**
     * Provedores de Usuário (User Provider)
     * Todos os drivers de autenticação têm um provedor de usuário (user provider).
     * Se a aplicação possuir multiplas tabelas de usuário ou entidades (models) deverão ser configuradas multiplas
     * fontes (sources) que representam cada entidade/tabela. Estas fontes (sources) deverão ser atribuídas a algum
     * guarda de autenticação extra definido.
     * Drivers Suportados: "eloquent" e "database".
     */
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\Usuario::class,
        ],
    ],

    /**
     * Redefinição de Senha
     * Deverão ser especificados multiplas configuração de redefinição de senha se a aplicação tiver mais de uma tabela
     * ou entidade de usuário e forem necessárias diferentes configurações de acordo com o tipo do usuário.
     */
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /**
     * Expiração da Confirmação de Senha
     * Aqui é definido a quantidade de segundos antes da confirmação da senha expirar e o usuário ser requisitado a
     * informar novamente a sua senha através da tela de confirmação.
     */
    'password_timeout' => 10800,
];
