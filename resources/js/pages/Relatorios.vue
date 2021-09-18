<template>
    <div>
        <NavBar/>
        <div class="container">
            <div class="row">
                <div class="col">
                    <br>
                    <h3>Relatórios</h3>
                    <br>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <form @submit.prevent="searchPedidos">
                        <div class="row align-items-end">
                            <div class="col">
                                <label class="form-label">Buscar Pedidos por...</label>
                                <select class="form-select form-select-sm" v-model="searchField" @change="clearPedidos"
                                        :disabled="isBusy">
                                    <option value="dataChegada">Data de Chegada</option>
                                    <option value="dataEnvioFinanceiro">Data de Envio ao Financeiro</option>
                                </select>
                            </div>

                            <div class="col">
                                <label class="form-label">&nbsp;</label>
                                <input class="form-control form-control-sm" ref="searchValueInput" type="date"
                                       v-model="searchValue" @change="clearPedidos" :disabled="isBusy">
                            </div>

                            <div class="col">
                                <button class="btn btn-sm btn-primary" type="submit"
                                        :disabled="!searchValue || !searchField || isBusy">
                                    Buscar
                                </button>

                                <button class="btn btn-sm btn-secondary" type="button" @click="clearForm"
                                        :disabled="isBusy">
                                    Limpar
                                </button>

                                <button class="btn btn-sm btn-secondary" type="button" @click="exportToPDF"
                                        :disabled="pedidos.length === 0 || isBusy">
                                    Exportar para PDF
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col">
                    <table class="table table-sm table-striped table-hover" v-if="pedidos.length > 0">
                        <thead>
                        <tr>
                            <th class="tc-w-15">#</th>
                            <th class="tc-w-25">Secretaria</th>
                            <th class="tc-w-20">Projeto</th>
                            <th class="tc-w-40">Descrição</th>
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
            </div>
        </div>
    </div>

</template>

<script>
import api from "../services/api";
import NavBar from "../components/NavBar";

export default {
    name: "Relatorios",

    components: {NavBar},

    data() {
        return {
            pedidos: [],
            searchField: "dataEnvioFinanceiro",
            searchValue: "",
            isBusy: false,
        };
    },

    methods: {
        exportToPDF() {
            //TODO: criar exportação para PDF.
        },

        async searchPedidos() {
            if (this.isBusy) return;

            this.isBusy = true;
            try {
                const {pedidos} = await api.pedidos.getPedidos({
                    [this.searchField]: this.searchValue,
                });
                this.pedidos = pedidos;

                //TODO: mudar de alert para uma popup.
                alert("Pedidos carregados com sucesso.");
            } catch (e) {
                //TODO: mudar de alert para uma popup.
                alert("Ocorreu um erro ao buscar os pedidos.");
            }
            this.isBusy = false;
        },

        clearPedidos() {
            this.pedidos = [];
        },

        clearForm() {
            if (this.isBusy) return;

            this.isBusy = true;
            this.pedidos = [];
            this.searchField = "dataEnvioFinanceiro";
            this.searchValue = "";
            this.isBusy = false;
        },

        mounted() {
            this.$refs.searchValueInput.focus();
        },
    },
};
</script>

<style lang="scss" scoped>
.tc-w-15 {
    width: 15%;
}

.tc-w-20 {
    width: 20%;
}

.tc-w-25 {
    width: 25%;
}

.tc-w-40 {
    width: 40%;
}
</style>
