<template>
    <div>
        <NavBar/>
        <div class="container">
            <div class="row">
                <div class="col">
                    <h3 class="my-4">Alterar Senha</h3>
                </div>
            </div>

            <div class="row">
                <div class="col mw-600px">
                    <form @submit.prevent="updateSenha">
                        <div class="row align-items-end">
                            <div class="col">
                                <label class="form-label col-form-label-sm">Nova Senha</label>
                                <input class="form-control form-control-sm" ref="newSenhaInput" type="password" required
                                       v-model="newSenha" :disabled="isBusy">
                            </div>

                            <div class="col">
                                <label class="form-label col-form-label-sm">Repita a Nova Senha</label>
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
import toaster from "../services/toaster";

/**
 * Página Alterar Senha.
 * Página que contém um formulário para alteração da senha do usuário que está atualmente conectado.
 */
export default {
    name: "AlterarSenha",

    components: {NavBar},

    data() {
        return {
            // Indicação de que há um comando em execução.
            isBusy: false,

            // Campos do formulário.
            newSenha: "",
            repeatNewSenha: "",
        };
    },

    methods: {
        /**
         * Atualiza a senha do usuário.
         *
         * @returns {Promise<void>}
         */
        async updateSenha() {
            // Cancela o comando caso outro comando esteja em execução.
            if (this.isBusy) return;

            // Cancela o comando e exibe um erro caso as senhas informadas sejam divergentes.
            if (this.newSenha !== this.repeatNewSenha) {
                return toaster.displayError("Os campos 'Nova Senha' e 'Repetir Nova Senha' não conferem.");
            }

            this.isBusy = true;
            try {
                // Busca no estado da aplicação o usuário autenticado.
                const usuario = this.$store.getters["auth/usuario"];

                // Faz uma requisição à API para alterar a senha do usuário.
                await api.usuarios.updateUsuario({
                    ...usuario,
                    senha: this.newSenha,
                });

                // Exibe uma mensagem de sucesso caso a operação seja concluída.
                toaster.displaySuccess("Senha alterada com sucesso. Caso a esqueça, contate o administrador para redefini-la.");

                // Navega para a página "pedidos".
                await this.$router.replace({name: "pedidos"});
            } catch (e) {
                // Exibe uma mensagem de erro caso a operação não seja concluída.
                toaster.displayError("Ocorreu um erro ao alterar a senha.");
            }
            this.isBusy = false;
        },

        mounted() {
            // Muda o foco para o input newSenha.
            this.$refs.newSenhaInput.focus();
        },
    },
};
</script>
