import Vue from "vue";
import VueRouter from "vue-router";

import Inicio from "./pages/Inicio";
import Login from "./pages/Login.vue";
import Pedidos from "./pages/Pedidos.vue";
import Relatorios from "./pages/Relatorios.vue";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",
    linkExactActiveClass: "active",
    routes: [
        {
            path: "/",
            name: "inicio",
            component: Inicio,
        },
        {
            path: "/login",
            name: "login",
            component: Login,
        },
        {
            path: "/pedidos",
            name: "pedidos",
            component: Pedidos,
        },
        {
            path: "/relatorios",
            name: "relatorios",
            component: Relatorios,
        },
    ],
});

export default router;
