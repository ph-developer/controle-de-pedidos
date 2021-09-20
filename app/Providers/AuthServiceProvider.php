<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Inicia os serviços de autenticação e autorização.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
