<template>
    <form @submit.prevent="doLogin">
        <input type="email" required v-model="email" placeholder="E-mail">
        <br>
        <input type="password" required v-model="senha" placeholder="Senha">
        <br>
        <button type="submit">Entrar</button>
    </form>
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
