<template>
    <div>
        <NavBar/>
        <div class="container">
            <div class="row">
                <div class="col">
                    <h3 class="my-4">Usuários</h3>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col mw-600px">
                    <form @submit.prevent="createUsuario">
                        <div class="row align-items-end">
                            <div class="col">
                                <label class="form-label col-form-label-sm">Nome</label>
                                <input class="form-control form-control-sm" ref="nomeInput" type="text" required
                                       v-model="nome" :disabled="isBusy">
                            </div>

                            <div class="col">
                                <label class="form-label col-form-label-sm">E-mail</label>
                                <input class="form-control form-control-sm" type="email" required v-model="email"
                                       :disabled="isBusy">
                            </div>

                            <div class="col">
                                <button class="btn btn-sm btn-primary" type="submit" :disabled="isBusy">
                                    Criar Usuário
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <table class="table table-sm table-striped table-hover">
                        <thead>
                        <tr>
                            <th class="w-40">Nome</th>
                            <th class="w-40">E-mail</th>
                            <th class="w-20 text-center">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="usuario in usuarios" :key="usuario.id">
                            <td>{{ usuario.nome }}</td>
                            <td>{{ usuario.email }}</td>
                            <td v-if="usuario.email === 'admin@admin.dev'">&nbsp;</td>
                            <td class="text-end" v-else>
                                <button class="btn btn-sm btn-danger" @click="deleteUsuario(usuario)"
                                        :disabled="isBusy">
                                    Excluir
                                </button>
                                <button class="btn btn-sm btn-primary" @click="redefineSenha(usuario)"
                                        :disabled="isBusy">
                                    Redefinir Senha
                                </button>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="3" class="text-end">
                                <button class="btn btn-sm btn-secondary" @click="loadUsuarios" :disabled="isBusy">
                                    Atualizar
                                </button>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import api from "../services/api";
import NavBar from "../components/NavBar";
import toaster from "../services/toaster";
import {generateRandomString} from "../helpers/string";

/**
 * Página Usuários.
 * Página que contém um formulário para cadastro de novos usuários.
 * A página possui uma tabela com os usuários existentes no sistema, possibilitando a exclusão e redefinição de senha.
 * Esta página só pode ser acessada pelo administrador do sistema.
 */
export default {
    name: "Usuarios",

    components: {NavBar},

    data() {
        return {
            // Indicação de que há um comando em execução.
            isBusy: false,

            // Lista de usuários carregados.
            usuarios: [],

            // Campos do formulário.
            nome: "",
            email: "",
        };
    },

    methods: {
        /**
         * Cria um novo usuário.
         *
         * @returns {Promise<void>}
         */
        async createUsuario() {
            // Cancela o comando caso outro comando esteja em execução.
            if (this.isBusy) return;

            // Cancela o comando e exibe um erro caso algum dos campos não estejam preenchidos.
            if (!this.nome || !this.email) {
                return toaster.displayError("Os campos 'Nome' e 'E-mail' devem ser preenchidos.");
            }

            this.isBusy = true;
            try {
                // Gera uma senha aleatória com 12 caracteres.
                const senha = generateRandomString(12);

                // Faz uma requisição à API para criar um novo usuário.
                await api.usuarios.createUsuario({
                    nome: this.nome,
                    email: this.email,
                    senha,
                });

                // Limpa os campos do formulário de cadastro.
                this.nome = this.email = "";

                this.isBusy = false;

                // Exibe uma mensagem de sucesso caso a operação seja concluída.
                toaster.displaySuccess(`Usuário de e-mail ${this.email} criado com sucesso. A senha do novo usuário é "${senha}".`);

                // Muda o foco para o input nome.
                this.$refs.nomeInput.focus();

                // Recarrega os usuários cadastrados.
                await this.loadUsuarios();
            } catch (e) {
                // Exibe uma mensagem de erro caso a operação não seja concluída.
                toaster.displayError("Ocorreu um erro ao criar o usuário.");

                this.isBusy = false;
            }
        },

        /**
         * Carrega os usuários cadastrados.
         *
         * @returns {Promise<void>}
         */
        async loadUsuarios() {
            // Cancela o comando caso outro comando esteja em execução.
            if (this.isBusy) return;

            this.isBusy = true;
            try {
                // Faz uma requisição à API para buscar os usuários cadastrados.
                const {usuarios} = await api.usuarios.getUsuarios();

                // Substitui os usuários no estado da página.
                this.usuarios = usuarios;
            } catch (e) {
                // Exibe uma mensagem de erro caso a operação não seja concluída.
                toaster.displayError("Ocorreu um erro ao carregar os usuários.");
            }
            this.isBusy = false;
        },

        /**
         * Exclui o usuário cujo id foi passado dentro do parâmetro "usuario".
         *
         * @param usuario Usuário que será excluído.
         * @returns {void}
         */
        deleteUsuario(usuario) {
            // Cancela o comando caso outro comando esteja em execução.
            if (this.isBusy) return;

            // Questiona o usuário confirmando a exclusão.
            toaster.displayConfirm(
                `Deseja realmente excluir o usuário de e-mail ${usuario.email}?`,
                // Operação que será executada caso o usuário pressione "Sim".
                async () => {
                    this.isBusy = true;
                    try {
                        // Faz uma requisição à API para excluir o usuário informado.
                        await api.usuarios.deleteUsuario(usuario.id);

                        // Exibe uma mensagem de sucesso caso a operação seja concluída.
                        toaster.displaySuccess("Usuário excluído com sucesso.");
                    } catch (e) {
                        // Exibe uma mensagem de erro caso a operação não seja concluída.
                        toaster.displayError("Ocorreu um erro ao excluir o usuário.");
                    }
                    this.isBusy = false;

                    // Recarrega os usuários cadastrados.
                    await this.loadUsuarios();
                },
            );
        },

        /**
         * Altera a senha aleatoriamente do usuário cujo id foi passado dentro do parâmetro "usuário".
         *
         * @param usuario Usuário que terá a senha redefinida.
         * @returns {void}
         */
        redefineSenha(usuario) {
            // Cancela o comando caso outro comando esteja em execução.
            if (this.isBusy) return;

            // Questiona o usuário confirmando a alteração da senha.
            toaster.displayConfirm(`Deseja realmente redefinir a senha do usuário de e-mail ${usuario.email}?`,
                // Operação que será executada caso o usuário pressione "Sim".
                async () => {
                    this.isBusy = true;
                    try {
                        // Gera uma senha aleatória com 12 caracteres.
                        const senha = generateRandomString(12);

                        // Faz uma requisição à API para alterar a senha do usuário informado.
                        await api.usuarios.updateUsuario({
                            id: usuario.id,
                            nome: usuario.nome,
                            email: usuario.email,
                            senha,
                        });

                        // Exibe uma mensagem de sucesso caso a operação seja concluída.
                        toaster.displaySuccess(`Senha redefinida com sucesso. A nova senha do usuário de e-mail ${usuario.email} é "${senha}".`);
                    } catch (e) {
                        // Exibe uma mensagem de erro caso a operação não seja concluída.
                        toaster.displayError("Ocorreu um erro ao redefinir a senha do usuário.");
                    }
                    this.isBusy = false;
                },
            );
        },
    },

    mounted() {
        // Muda o foco para o input newSenha.
        this.$refs.nomeInput.focus();

        // Carrega os usuários cadastrados.
        this.loadUsuarios();
    },
};
</script>
