<template>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand">Controle de Pedidos</span>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/pedidos" active-class="active">
                            Pedidos
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/relatorios" active-class="active">
                            Relatórios
                        </router-link>
                    </li>

                    <li class="nav-item" v-if="isAdmin">
                        <router-link class="nav-link" to="/usuarios" active-class="active">
                            Usuários
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <router-link class="nav-link" to="/alterar-senha" active-class="active">
                            Alterar Senha
                        </router-link>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <b class="nav-link">{{ usuario["nome"] }}</b>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link c-pointer" @click="doLogout">Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import api from "../services/api";
import {mapGetters} from "vuex";
import store from "../store";

export default {
    name: "NavBar",

    computed: {
        ...mapGetters({
            isAdmin: "auth/isAdmin",
            usuario: "auth/usuario",
        }),
    },

    methods: {
        async doLogout() {
            await api.auth.doLogout();
            store.commit("auth/setIsAuthenticated", false);
            store.commit("auth/setUsuario", null);
            await this.$router.replace({name: "login"});
        },
    },
};
</script>

<style lang="scss" scoped>
.c-pointer {
    cursor: pointer;
}
</style>
