/**
 * Carregamento do plugin Bootstrap que fornece suporte para recursos baseados
 * em JavaScript, como modais e guias.
 */

require("bootstrap");

/**
 * Carregamento da biblioteca axios HTTP que nos permite facilmente fazer solicitações
 * para o nosso back-end do Laravel. Esta biblioteca lida automaticamente com o envio
 * do token CSRF como um cabeçalho com base no valor do cookie do token "XSRF".
 */

window.axios = require("axios");

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

window.axios.defaults.withCredentials = true;

/**
 * Echo expõe uma API expressiva para se inscrever em canais e ouvir eventos que são
 * transmitidos pelo Laravel. A transmissão de eco e eventos permite que sejam criados
 * facilmente aplicativos da web robustos em tempo real.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
