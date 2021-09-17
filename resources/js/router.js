import Vue from "vue";
import VueRouter from "vue-router";
import store from "./store";

import Inicio from "./pages/Inicio";
import Login from "./pages/Login.vue";
import Pedidos from "./pages/Pedidos.vue";
import Relatorios from "./pages/Relatorios.vue";
import Usuarios from "./pages/Usuarios";
import AlterarSenha from "./pages/AlterarSenha";
import api from "./services/api";

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
            meta: {requireAuth: true},
        },
        {
            path: "/relatorios",
            name: "relatorios",
            component: Relatorios,
            meta: {requireAuth: true},
        },
        {
            path: "/alterar-senha",
            name: "alterar-senha",
            component: AlterarSenha,
            meta: {requireAuth: true},
        },
        {
            path: "/usuarios",
            name: "usuarios",
            component: Usuarios,
            meta: {requireAuth: true, requireAdmin: true},
        },
        {path: "/:pathMatch(.*)*", redirect: "/"},
    ],
});

router.beforeEach(async ({meta}, from, next) => {
    if (store.getters["auth/isLoading"]) {
        try {
            const usuario = await api.auth.getUsuario();
            store.commit("auth/setIsAuthenticated", true);
            store.commit("auth/setUsuario", usuario);
        } catch (e) {
            store.commit("auth/setIsAuthenticated", false);
            store.commit("auth/setUsuario", null);
        }
        store.commit("auth/setIsLoading", false);

        if (meta.requireAuth && !store.getters["auth/isAuthenticated"]) {
            //TODO: mudar de alert para uma popup.
            alert("Você não está autenticado.");
            return next({name: "login"});
        } else if (meta.requireAdmin && store.getters["auth/usuario"]?.nome !== "Admin") {
            //TODO: mudar de alert para uma popup.
            alert("Você não tem permissão.");
            return next({name: "pedidos"});
        }
    }

    return next();
});

export default router;
