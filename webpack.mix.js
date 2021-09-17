const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Gerenciamento de Assets pelo Mix
 |--------------------------------------------------------------------------
 |
 | O Mix fornece uma API limpa e fluente para definir algumas etapas de
 | construção do Webpack para seu aplicativo Laravel. Por padrão, estamos
 | compilando o arquivo Sass para o aplicativo, bem como agrupando todos
 | os arquivos JS.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');
