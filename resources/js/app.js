/**
 * Carregamento de todas as dependências de JavaScript deste projeto, que
 * incluem o Vue e outras bibliotecas.
 */

require("./bootstrap");

window.Vue = require("vue").default;

import router from "./router";
import store from "./store";
import App from "./layouts/App.vue";

/**
 * Carrega o Cookie CSRF e inicia um intervalo que recarrega o Cookie CSRF
 * a cada 5 minutos.
 */

import api from "./services/api";

api.app.getCsrfCookie();
setInterval(() => {
    api.app.getCsrfCookie();
}, 1000 * 60 * 5);

/**
 * Criação de uma nova instância do aplicativo Vue anexada à página.
 */

const app = new Vue({
    router,
    store,
    el: "#app",
    render: h => h(App),
});
