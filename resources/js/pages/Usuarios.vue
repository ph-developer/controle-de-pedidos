<template>
    <div>
        <form @submit.prevent="createUsuario">
            <input ref="nomeInput" type="text" required v-model="nome" placeholder="Nome">
            <input type="email" required v-model="email" placeholder="E-mail">
            <button type="submit">Criar Usuário</button>
        </form>
        <button @click="loadUsuarios" :disabled="isLoadingUsuarios">Recarregar</button>
        <table>
            <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="usuario in usuarios" :key="usuario.id">
                <td>{{ usuario.nome }}</td>
                <td>{{ usuario.email }}</td>
                <td>
                    <button @click="deleteUsuario(usuario)">Excluir</button>
                    <button @click="redefineSenha(usuario)">Redefinir Senha</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import api from "../services/api";

export default {
    name: "Usuarios",

    data() {
        return {
            isLoadingUsuarios: false,
            usuarios: [],
            nome: "",
            email: "",
        };
    },

    methods: {
        async createUsuario() {
            if (!this.nome || !this.email) {
                //TODO: mudar de alert para uma popup.
                return alert("Os campos 'Nome' e 'E-mail' devem ser preenchidos.");
            }

            try {
                const senha = this.generateRandomString();
                await api.usuarios.createUsuario({
                    nome: this.nome,
                    email: this.email,
                    senha,
                });

                this.nome = this.email = "";

                //TODO: mudar de alert para uma popup.
                alert(`Usuário de e-mail ${this.email} criado com sucesso. A senha do novo usuário é "${senha}".`);

                this.$refs.nomeInput.focus();
                await this.loadUsuarios();
            } catch (e) {
                //TODO: mudar de alert para uma popup.
                alert("Ocorreu um erro ao criar o usuário.");
            }
        },

        async loadUsuarios() {
            if (this.isLoadingUsuarios) return;

            try {
                this.isLoadingUsuarios = true;
                const {usuarios} = await api.usuarios.getUsuarios();
                this.usuarios = usuarios;
                this.isLoadingUsuarios = false;
            } catch (e) {
                //TODO: mudar de alert para uma popup.
                alert("Ocorreu um erro ao carregar os usuários.");
            }
        },

        async deleteUsuario(usuario) {
            //TODO: mudar de confirm para uma popup.
            if (!confirm(`Deseja realmente excluir o usuário de e-mail ${usuario.email}?`)) return;

            try {
                await api.usuarios.deleteUsuario(usuario.id);

                //TODO: mudar de alert para uma popup.
                alert("Usuário excluído com sucesso.");

                await this.loadUsuarios();
            } catch (e) {
                //TODO: mudar de alert para uma popup.
                alert("Ocorreu um erro ao excluir o usuário.");
            }
        },

        async redefineSenha(usuario) {
            //TODO: mudar de confirm para uma popup.
            if (!confirm(`Deseja realmente redefinir a senha do usuário de e-mail ${usuario.email}?`)) return;

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
