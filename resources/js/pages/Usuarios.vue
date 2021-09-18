<template>
    <div>
        <NavBar/>
        <div class="container">
            <div class="row">
                <div class="col">
                    <br>
                    <h3>Usuários</h3>
                    <br>
                </div>
            </div>

            <div class="row">
                <div class="col mw-600">
                    <form @submit.prevent="createUsuario">
                        <div class="row align-items-end">
                            <div class="col">
                                <label class="form-label">Nome</label>
                                <input class="form-control form-control-sm" ref="nomeInput" type="text" required
                                       v-model="nome" :disabled="isBusy">
                            </div>

                            <div class="col">
                                <label class="form-label">E-mail</label>
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

            <br>

            <div class="row">
                <div class="col">
                    <table class="table table-sm table-striped table-hover">
                        <thead>
                        <tr>
                            <th class="tc-w-40">Nome</th>
                            <th class="tc-w-40">E-mail</th>
                            <th class="tc-w-20 text-center">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="usuario in usuarios" :key="usuario.id">
                            <td>{{ usuario.nome }}</td>
                            <td>{{ usuario.email }}</td>
                            <td class="text-end">
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
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td class="text-end">
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

export default {
    name: "Usuarios",

    components: {NavBar},

    data() {
        return {
            isBusy: false,
            usuarios: [],
            nome: "",
            email: "",
        };
    },

    methods: {
        async createUsuario() {
            if (this.isBusy) return;

            if (!this.nome || !this.email) {
                //TODO: mudar de alert para uma popup.
                return alert("Os campos 'Nome' e 'E-mail' devem ser preenchidos.");
            }

            this.isBusy = true;
            try {
                const senha = this.generateRandomString();
                await api.usuarios.createUsuario({
                    nome: this.nome,
                    email: this.email,
                    senha,
                });
                this.nome = this.email = "";
                this.isBusy = false;

                //TODO: mudar de alert para uma popup.
                alert(`Usuário de e-mail ${this.email} criado com sucesso. A senha do novo usuário é "${senha}".`);

                this.$refs.nomeInput.focus();
                await this.loadUsuarios();
            } catch (e) {
                //TODO: mudar de alert para uma popup.
                alert("Ocorreu um erro ao criar o usuário.");
                this.isBusy = false;
            }
        },

        async loadUsuarios() {
            if (this.isBusy) return;

            this.isBusy = true;
            try {
                const {usuarios} = await api.usuarios.getUsuarios();
                this.usuarios = usuarios;
            } catch (e) {
                //TODO: mudar de alert para uma popup.
                alert("Ocorreu um erro ao carregar os usuários.");
            }
            this.isBusy = false;
        },

        async deleteUsuario(usuario) {
            if (this.isBusy) return;

            //TODO: mudar de confirm para uma popup.
            if (!confirm(`Deseja realmente excluir o usuário de e-mail ${usuario.email}?`)) return;

            this.isBusy = true;
            try {
                await api.usuarios.deleteUsuario(usuario.id);

                //TODO: mudar de alert para uma popup.
                alert("Usuário excluído com sucesso.");

                await this.loadUsuarios();
            } catch (e) {
                //TODO: mudar de alert para uma popup.
                alert("Ocorreu um erro ao excluir o usuário.");
            }
            this.isBusy = false;
        },

        async redefineSenha(usuario) {
            if (this.isBusy) return;

            //TODO: mudar de confirm para uma popup.
            if (!confirm(`Deseja realmente redefinir a senha do usuário de e-mail ${usuario.email}?`)) return;

            this.isBusy = true;
            try {
                const senha = this.generateRandomString();
                await api.usuarios.updateUsuario({
                    id: usuario.id,
                    nome: usuario.nome,
                    email: usuario.email,
                    senha,
                });

                //TODO: mudar de alert para uma popup.
                alert(`Senha redefinida com sucesso. A nova senha do usuário de e-mail ${usuario.email} é "${senha}".`);
            } catch (e) {
                //TODO: mudar de alert para uma popup.
                alert("Ocorreu um erro ao redefinir a senha do usuário.");
            }
            this.isBusy = false;
        },

        /**
         * Gera uma string aleatória de 12 dígitos.
         * @returns {string}
         */
        generateRandomString() {
            const chars = "0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            let password = "";

            for (let i = 0; i <= 12; i++) {
                const randomNumber = Math.floor(Math.random() * chars.length);
                password += chars.substring(randomNumber, randomNumber + 1);
            }

            return password;
        },
    },

    mounted() {
        this.$refs.nomeInput.focus();
        this.loadUsuarios();
    },
};
</script>

<style lang="scss" scoped>
.mw-600 {
    max-width: 600px;
}

.tc-w-20 {
    width: 20%;
}

.tc-w-40 {
    width: 40%;
}
</style>
