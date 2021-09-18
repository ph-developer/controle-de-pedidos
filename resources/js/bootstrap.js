/**
 * Carregamento do plugin Bootstrap que fornece suporte para recursos baseados em JavaScript, como modais e guias.
 */

require("bootstrap");

/**
 * Carregamento da biblioteca axios HTTP que nos permite facilmente fazer solicitações para o nosso back-end do Laravel.
 * Esta biblioteca lida automaticamente com o envio do token CSRF como um cabeçalho com base no valor do cookie do token
 * "XSRF".
 */

window.axios = require("axios");

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

window.axios.defaults.withCredentials = true;
