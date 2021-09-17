<template>
    <div>
        <button @click="exportToPDF" :disabled="pedidos.length === 0 || isSearchingPedidos">Exportar para PDF</button>
        <form @submit.prevent="searchPedidos">
            <select v-model="searchField" @change="clearPedidos">
                <option value="dataChegada">Data de Chegada</option>
                <option value="dataEnvioFinanceiro">Data de Envio ao Financeiro</option>
            </select>
            <input ref="searchValueInput" type="date" v-model="searchValue" @change="clearPedidos">
            <button type="submit" :disabled="!searchValue || !searchField || isSearchingPedidos">Buscar</button>
            <button type="button" @click="clearForm" :disabled="isSearchingPedidos">Limpar</button>
        </form>
        <table v-if="pedidos.length > 0">
            <thead>
            <tr>
                <th>#</th>
                <th>Secretaria</th>
                <th>Projeto</th>
                <th>Descrição</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="pedido in pedidos" :key="pedido.id">
                <td>{{ `${pedido.tipo} ${pedido.numero}` }}</td>
                <td>{{ pedido.secretariaSolicitante }}</td>
                <td>{{ pedido.projeto }}</td>
                <td>{{ pedido.descricao }}</td>
            </tr>
            </tbody>
        </table>
        <p v-else>Nenhum pedido...</p>
    </div>
</template>

<script>
import api from "../services/api";

export default {
    name: "Relatorios",

    data() {
        return {
            pedidos: [],
            searchField: "dataEnvioFinanceiro",
            searchValue: "",
            isSearchingPedidos: false,
            isClearingForm: false,
        };
    },

    methods: {
        exportToPDF() {
            //TODO: criar exportação para PDF.
        },

        async searchPedidos() {
            if (this.isSearchingPedidos || this.isClearingForm) return;

            try {
                this.isSearchingPedidos = true;
                const {pedidos} = await api.pedidos.getPedidos({
                    [this.searchField]: this.searchValue,
                });
                this.pedidos = pedidos;
                this.isSearchingPedidos = false;

                //TODO: mudar de alert para uma popup.
                alert("Pedidos carregados com sucesso.");
            } catch (e) {
                //TODO: mudar de alert para uma popup.
                alert("Ocorreu um erro ao buscar os pedidos.");
            }
        },

        clearPedidos() {
            this.pedidos = [];
        },

        clearForm() {
            this.pedidos = [];
            this.isClearingForm = true;
            this.searchField = "dataEnvioFinanceiro";
            this.searchValue = "";
            this.isClearingForm = false;
        },

        mounted() {
            this.$refs.searchValueInput.focus();
        },
    },
};
</script>
