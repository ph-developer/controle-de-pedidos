<?php

/**
 * Criação da Aplicação
 * Inicialmente, nós criamos a nova instância da aplicação Laravel que serve como uma "cola" entre todos os componentes
 * do Laravel, e seu container IoC liga todas as partes.
 */

$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

/**
 * Vinculação das Interfaces Importantes (Binding)
 * Aqui, precisamos vincular algumas interfaces importantes ao container para que possamos usá-las quando necessário.
 * Os kernels atendem às solicitações de entrada para o aplicativo web e para a CLI.
 */

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/**
 * Retorna a Aplicação
 * O script retorna a instância da aplicação. A instância é dada ao script de chamada, então podemos separar a construção
 * das instâncias da execução atual da aplicação e do envio de respostas.
 */

return $app;
