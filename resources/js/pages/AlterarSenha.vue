<template>
    <div>
        <NavBar/>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col mw-330">
                    <form @submit.prevent="updateSenha">
                        <br>
                        <h3>Alterar Senha</h3>
                        <br>

                        <p>
                            <label class="form-label" for="newSenhaInput">Nova Senha</label>
                            <input class="form-control" id="newSenhaInput" ref="newSenhaInput" type="password" required
                                   v-model="newSenha">
                        </p>

                        <p>
                            <label class="form-label" for="repeatNewSenhaInput">Repita a Nova Senha</label>
                            <input class="form-control" id="repeatNewSenhaInput" type="password" required
                                   v-model="repeatNewSenha">
                        </p>

                        <p class="d-grid gap-2">
                            <button class="btn btn-primary" type="submit">Alterar Senha</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
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

<style lang="scss" scoped>
.mw-330 {
    max-width: 330px;
}
</style>
