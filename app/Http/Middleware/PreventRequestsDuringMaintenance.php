<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

class PreventRequestsDuringMaintenance extends Middleware
{
    /**
     * URIs (caminhos) que o acesso será bloqueado enquanto o modo de manutenção estiver habilitado.
     *
     * @var array
     */
    protected $except = [
        //
    ];
}
