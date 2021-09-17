<template>
    <div class="container vh-100">
        <div class="row h-100 align-items-center justify-content-center">
            <div class="col mw-330">
                <form @submit.prevent="doLogin">
                    <p class="w-100 fs-1 text-primary text-center">
                        <i class="fas fa-user"></i>
                    </p>

                    <p>
                        <label class="form-label" for="emailInput">E-mail</label>
                        <input class="form-control" id="emailInput" type="email" required v-model="email" autofocus>
                    </p>

                    <p>
                        <label class="form-label" for="senhaInput">Senha</label>
                        <input class="form-control" id="senhaInput" type="password" required v-model="senha">
                    </p>

                    <p class="d-grid gap-2">
                        <button class="btn btn-primary" type="submit">Entrar</button>
                    </p>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import api from "../services/api";

export default {
    name: "Login",

    data() {
        return {
            email: "",
            senha: "",
        };
    },

    methods: {
        async doLogin() {
            try {
                await api.auth.doLogin(this.email, this.senha);
                await this.$router.replace({name: "pedidos"});
            } catch (e) {
                //TODO: mudar de alert para uma popup.
                alert("E-mail ou Senha incorreto.");
            }
        },
    },
};
</script>

<style lang="scss" scoped>
.mw-330 {
    max-width: 330px;
}
</style>
