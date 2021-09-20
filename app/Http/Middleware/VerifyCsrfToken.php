<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Lista de URIs que serão excluídas da verificação de CSRF.
     *
     * @var array
     */
    protected $except = [
        //
    ];
}
