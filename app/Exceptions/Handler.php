<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Lista de exceções que não serão reportadas.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * Lista de entradas (input) que nunca serão guardadas durante exceções de validação.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Registra os callbacks de retorno para manipulação de exceções.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
