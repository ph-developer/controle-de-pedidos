<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * Nomes dos cookies que não serão criptografados.
     *
     * @var array
     */
    protected $except = [
        //
    ];
}
