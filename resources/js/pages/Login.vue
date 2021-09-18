<template>
    <div class="container vh-100">
        <div class="row h-100 align-items-center justify-content-center">
            <div class="col mw-330">
                <form @submit.prevent="doLogin">
                    <p class="w-100 fs-1 text-primary text-center">
                        <i class="fas fa-user"></i>
                    </p>

                    <p>
                        <label class="form-label">E-mail</label>
                        <input class="form-control form-control-sm" type="email" required v-model="email" autofocus
                               :disabled="isBusy">
                    </p>

                    <p>
                        <label class="form-label">Senha</label>
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

export default {
    name: "Login",

    data() {
        return {
            isBusy: false,
            email: "",
            senha: "",
        };
    },

    methods: {
        async doLogin() {
            if (this.isBusy) return;

            this.isBusy = true;
            try {
                await api.auth.doLogin(this.email, this.senha);
                const usuario = await api.auth.getUsuario();
                store.commit("auth/setIsAuthenticated", true);
                store.commit("auth/setUsuario", usuario);
                await this.$router.replace({name: "pedidos"});
            } catch (e) {
                store.commit("auth/setIsAuthenticated", false);
                store.commit("auth/setUsuario", null);
                //TODO: mudar de alert para uma popup.
                alert("E-mail ou Senha incorreto.");
            }
            this.isBusy = false;
        },
    },
};
</script>

<style lang="scss" scoped>
.mw-330 {
    max-width: 330px;
}
</style>
