<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Caminho para a rota "home" da aplicação.
     * Esta variável é utilizada pelo serviço de autenticação do Laravel para redirecionar os usuários após o login.
     * Mesmo a aplicação utilizando apenas autenticação via API, é necessário manter esta variável para que a aplicação
     * funcione corretamente.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Inicia os serviços de roteamento.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configura os limitadores de acesso para o aplicativo, prevenindo ataques DDoS.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
