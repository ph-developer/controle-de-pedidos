<template>
    <div>
        <NavBar/>
        <div class="container">
            <div class="row">
                <div class="col">
                    <br>
                    <h3>Alterar Senha</h3>
                    <br>
                </div>
            </div>

            <div class="row">
                <div class="col mw-600">
                    <form @submit.prevent="updateSenha">
                        <div class="row align-items-end">
                            <div class="col">
                                <label class="form-label">Nova Senha</label>
                                <input class="form-control form-control-sm" ref="newSenhaInput" type="password" required
                                       v-model="newSenha" :disabled="isBusy">
                            </div>

                            <div class="col">
                                <label class="form-label">Repita a Nova Senha</label>
                                <input class="form-control form-control-sm" type="password" required
                                       v-model="repeatNewSenha" :disabled="isBusy">
                            </div>

                            <div class="col">
                                <button class="btn btn-sm btn-primary" type="submit" :disabled="isBusy">
                                    Alterar Senha
                                </button>
                            </div>
                        </div>
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
            isBusy: false,
            newSenha: "",
            repeatNewSenha: "",
        };
    },

    methods: {
        async updateSenha() {
            if (this.isBusy) return;

            if (this.newSenha !== this.repeatNewSenha) {
                //TODO: mudar de alert para uma popup.
                return alert("Os campos 'Nova Senha' e 'Repetir Nova Senha' não conferem.");
            }

            this.isBusy = true;
            try {
                const usuario = this.$store.getters["auth/usuario"];
                await api.usuarios.updateUsuario({
                    ...usuario,
                    senha: this.newSenha,
                });

                //TODO: mudar de alert para uma popup.
                alert("Senha alterada com sucesso. Caso a esqueça, contate o administrador para redefini-la.");

                await this.$router.replace({name: "pedidos"});
            } catch (e) {
                //TODO: mudar de alert para uma popup.
                alert("Ocorreu um erro ao alterar a senha.");
            }
            this.isBusy = false;
        },

        mounted() {
            this.$refs.newSenhaInput.focus();
        },
    },
};
</script>

<style lang="scss" scoped>
.mw-600 {
    max-width: 600px;
}
</style>
