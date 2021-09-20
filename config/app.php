<?php

return [
    /**
     * Nome da Aplicação
     * Este é o nome da aplicação. O nome é usado quando o framework precisa colocar o nome da aplicação em uma
     * notificação ou outro lugar conforme a necessidade da aplicação ou de seus pacotes.
     */
    'name' => 'Controle de Pedidos',

    /**
     * Ambiente da Aplicação (Environment)
     * Este valor indica o "ambiente" atual que a aplicação está rodando. Isso determina a configuração de vários
     * serviços que a aplicação utiliza. Altere isso no arquivo ".env".
     */
    'env' => env('APP_ENV', 'production'),

    /**
     * Modo de Debug da Aplicação
     * Quando a aplicação está no modo de Debug, mensagens detalhadas de erro com "stack traces" serão exibidas em cada
     * erro que ocorrer com a aplicação. Se estiver desabilitado, um simples e genérico erro será mostrado.
     */
    'debug' => (bool)env('APP_DEBUG', false),

    /**
     * Caminho (URL) da aplicação
     * Essa URL é usada pelo console para gerar corretamente URLs quando o Artisan CLI for utilizado. Você deve atribuir
     * o valor da raiz (root) da aplicação, então esse valor será utilizado quando tarefas do Artisan forem executadas.
     */
    'url' => env('APP_URL', 'http://localhost'),
    'asset_url' => env('ASSET_URL', null),

    /**
     * Fuso Horário da Aplicação
     * Aqui você deve especificar o fuso horário padrão da aplicação, o qual será utilizado pelas funções de data (date)
     * de data/tempo (datetime) do PHP.
     */
    'timezone' => 'America/Sao_Paulo',

    /**
     * Localidade da Aplicação
     * A localidade da aplicação determina o padrão que será utilizado pelo serviço de tradução.
     */
    'locale' => 'pt-BR',

    /**
     * Localidade de Fallback da Aplicação
     * A localidade de fallback determina a localidade que será utilizada quando a localidade padrão não estiver
     * disponível.
     */
    'fallback_locale' => 'en',

    /**
     * Localidade do Faker
     * Esta localidade será utilizada pela biblioteca PHP Faker quando forem gerados dados para o semear do banco de
     * dados. Por exemplo, isso será utilizado para gerar números de telefones locais, endereços e outros.
     */
    'faker_locale' => 'pt_BR',

    /**
     * Chave de Criptografia
     * Esta chave será utilizada pelo Serviço de Criptografia do Illuminate e deve ser uma string randômica de 32
     * caracteres. Caso não atenda os requisitos, a aplicação não será segura.
     */
    'key' => env('APP_KEY'),
    'cipher' => 'AES-256-CBC',

    /**
     * Provedores de Serviços Carregados Automaticamente
     * Os provedores de serviços listados aqui serão automaticamente carregados nas requisições da aplicação.
     */
    'providers' => [
        /**
         * Provedores de Serviços do Framework Laravel.
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /**
         * Provedores de Serviços da Aplicação.
         */
        App\Providers\AuthServiceProvider::class,
        App\Providers\FortifyServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
    ],

    /**
     * Apelidos (Aliases) das Classes
     * Esta lista de apelidos (aliases) serão registradas quando a aplicação inicializar.
     * Os apelidos (aliases) são carregados tardiamente, então não afetam o desempenho da aplicação.
     */
    'aliases' => [
        'App' => Illuminate\Support\Facades\App::class,
        'Arr' => Illuminate\Support\Arr::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'Date' => Illuminate\Support\Facades\Date::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Http' => Illuminate\Support\Facades\Http::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'RateLimiter' => Illuminate\Support\Facades\RateLimiter::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'Str' => Illuminate\Support\Str::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,
    ],
];
