/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue").default;

import router from "./router";
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
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    router,
    el: "#app",
    render: h => h(App),
});
