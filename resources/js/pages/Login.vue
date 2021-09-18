<template>
    <div class="container vh-100">
        <div class="row h-100 align-items-center justify-content-center">
            <div class="col mw-330px">
                <form @submit.prevent="doLogin">
                    <p class="w-100 fs-1 text-primary text-center">
                        <i class="fas fa-user"></i>
                    </p>

                    <p>
                        <label class="form-label col-form-label-sm">E-mail</label>
                        <input class="form-control form-control-sm" type="email" required v-model="email" autofocus
                               :disabled="isBusy">
                    </p>

                    <p>
                        <label class="form-label col-form-label-sm">Senha</label>
                        <input class="form-control form-control-sm" type="password" required v-model="senha"
                               :disabled="isBusy">
                    </p>

                    <p class="d-grid gap-2">
                        <button class="btn btn-sm btn-primary" type="submit" :disabled="isBusy">
                            Entrar
                        </button>
                    </p>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import api from "../services/api";
import store from "../store";
import toaster from "../services/toaster";

/**
 * Página Login.
 * Página que contém o formulário de login da aplicação.
 */
export default {
    name: "Login",

    data() {
        return {
            // Indicação de que há um comando em execução.
            isBusy: false,

            // Campos do formulário.
            email: "",
            senha: "",
        };
    },

    methods: {
        /**
         * Efetua o login do usuário.
         *
         * @returns {Promise<void>}
         */
        async doLogin() {
            // Cancela o comando caso outro comando esteja em execução.
            if (this.isBusy) return;

            this.isBusy = true;
            try {
                // Faz uma requisição à API para logar o usuário.
                await api.auth.doLogin(this.email, this.senha);

                // Verifica se o login foi efetuado com sucesso.
                const usuario = await api.auth.getUsuario();

                // Salva no estado da aplicação o usuário e status de autenticação.
                store.commit("auth/setIsAuthenticated", true);
                store.commit("auth/setUsuario", usuario);

                // Navega para a página "pedidos".
                await this.$router.replace({name: "pedidos"});
            } catch (e) {
                // Remove do estado da aplicação o usuário e altera o status de autenticação.
                store.commit("auth/setIsAuthenticated", false);
                store.commit("auth/setUsuario", null);

                // Exibe uma mensagem de erro caso o login não seja concluído.
                toaster.displayError("E-mail ou Senha incorreto.");
            }
            this.isBusy = false;
        },
    },
};
</script>
