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
import toaster from "./services/toaster";

// Aplica o plugin VueRouter (controlador de rotas) na aplicação.
Vue.use(VueRouter);

// Inicializa e configura o controlador de rotas da aplicação.
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

        // Configuração que permite que que o usuário seja redirecionado a página inicial caso tente entrar em uma rota
        // que não existe.
        {
            path: "/:pathMatch(.*)*",
            redirect: "/",
        },
    ],
});

/**
 * Função atribuída ao roteador que controla as permissões de acesso às páginas.
 * Para as rotas que possuirem em seus dados "meta" o valor "true" em requireAuth, a função verificará se o usuário está
 * autenticado antes de permitir o acesso à rota. Caso o usuário não esteja autenticado, ele será redirecionado à página
 * de login.
 * Para as rotas que possuem em seus dados "meta" o valor "true" em requireAdmin, a função verificará se o usuário é o
 * administrador do sistema antes de permitir o acesso à rota. Caso o usuário não seja o administrado, ele será
 * redirecionado à página "pedidos", onde será verificado novamente se ele está autenticado.
 */
router.beforeEach(async ({meta}, from, next) => {
    // Caso o estado da aplicação esteja sendo carregado, efetua a verificação de autenticação da sessão com o banco de
    // dados.
    if (store.getters["auth/isLoading"]) {
        try {
            // Faz uma requisição à API para consultar se a sessão tem um usuário autenticado.
            const usuario = await api.auth.getUsuario();

            // Salva no estado da aplicação o usuário e status de autenticação.
            store.commit("auth/setIsAuthenticated", true);
            store.commit("auth/setUsuario", usuario);
        } catch (e) {
            // Remove do estado da aplicação o usuário e altera o status de autenticação.
            store.commit("auth/setIsAuthenticated", false);
            store.commit("auth/setUsuario", null);
        }

        // Define no estado da aplicação que o carregamento foi concluído.
        store.commit("auth/setIsLoading", false);
    }

    // Verifica se o usuário está autenticado.
    if (meta.requireAuth && !store.getters["auth/isAuthenticated"]) {
        // Exibe uma mensagem de erro caso o usuário não esteja autenticado.
        toaster.displayError("Você não está autenticado.");

        // Redireciona o usuário para a página de login.
        return next({name: "login"});

    }
    // Verifica se o usuário é o administrador.
    else if (meta.requireAdmin && !store.getters["auth/isAdmin"]) {
        // Exibe uma mensagem de erro caso o usuário não seja o administrador.
        toaster.displayError("Você não tem permissão.");

        // Redireciona o usuário para a página "pedidos".
        return next({name: "pedidos"});
    }

    // Permite o acesso à rota pretendida pelo usuário.
    return next();
});

export default router;
