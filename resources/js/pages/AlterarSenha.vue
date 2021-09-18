<template>
    <div>
        <NavBar/>
        <form @submit.prevent="updateSenha">
            <input ref="newSenhaInput" type="password" required v-model="newSenha" placeholder="Nova Senha">
            <br>
            <input type="password" required v-model="repeatNewSenha" placeholder="Repita a Nova Senha">
            <br>
            <button type="submit">Alterar Senha</button>
        </form>
    </div>
</template>

<script>
import api from "../services/api";
import NavBar from "../components/NavBar";

export default {
    name: "AlterarSenha",

    components: {NavBar},

    data() {
        return {
            newSenha: "",
            repeatNewSenha: "",
        };
    },

    methods: {
        async updateSenha() {
            if (this.newSenha !== this.repeatNewSenha) {
                //TODO: mudar de alert para uma popup.
                return alert("Os campos 'Nova Senha' e 'Repetir Nova Senha' não conferem.");
            }

            try {
                const usuario = this.$store.getters["auth/usuario"];
                await api.usuarios.updateUsuario({
                    ...usuario,
                    senha: this.newSenha,
                });
                //TODO: mudar de alert para uma popup.
                alert("Senha alterada com sucesso. Caso a esqueça, contate o administrador para redefini-la.");
                await this.$router.replace({name: "pedidos"});
                this.$refs.newSenhaInput.focus();
            } catch (e) {
                //TODO: mudar de alert para uma popup.
                alert("Ocorreu um erro ao alterar a senha.");
            }
        },

        mounted() {
            this.$refs.newSenhaInput.focus();
        },
    },
};
</script>
