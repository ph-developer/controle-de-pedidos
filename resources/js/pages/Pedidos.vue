<template>
    <form @submit.prevent>
        <input ref="numeroInput" type="text" v-model="numero" placeholder="Número" @input="debounceSearchPedido">
        <br>
        <select v-model="tipo" @change="debounceSearchPedido">
            <option value="SE">SE</option>
            <option value="RM">RM</option>
        </select>
        <br>
        <input type="date" v-model="dataChegada">
        <br>
        <input type="text" v-model="secretariaSolicitante" placeholder="Secretaria Solicitante">
        <br>
        <input type="text" v-model="projeto" placeholder="Projeto">
        <br>
        <textarea v-model="descricao"/>
        <br>
        <input type="date" v-model="dataEnvioFinanceiro">
        <br>
        <input type="date" v-model="dataRetornoFinanceiro">
        <br>
        <input type="text" v-model="situacaoAutorizacao" placeholder="Situação da Autorização">
        <br>
        <textarea v-model="observacoes"/>
        <br>
        <button v-if="!existentPedido" id="createPedidoButton" @click="createPedido" :disabled="!numero || !tipo">Gravar
        </button>
        <button v-else id="updatePedidoButton" @click="updatePedido" :disabled="!numero || !tipo">Alterar</button>
        <br>
        <button id="deletePedidoButton" @click="deletePedido" :disabled="!existentPedido || !numero || !tipo">Excluir
        </button>
        <br>
        <button id="clearFormButton" @click="clearForm">Limpar</button>
    </form>
</template>

<script>
import api from "../services/api";
import _ from "lodash";

export default {
    name: "Pedidos",

    data() {
        return {
            existentPedido: false,
            numero: "",
            tipo: "SE",
            dataChegada: "",
            secretariaSolicitante: "",
            projeto: "",
            descricao: "",
            dataEnvioFinanceiro: "",
            dataRetornoFinanceiro: "",
            situacaoAutorizacao: "",
            observacoes: "",
        };
    },

    methods: {
        debounceSearchPedido: _.debounce(async function () {
            if (this.numero && this.tipo) {
                try {
                    const {pedido} = await api.pedidos.getPedido(this.tipo, this.numero);
                    this.dataChegada = pedido.dataChegada;
                    this.secretariaSolicitante = pedido.secretariaSolicitante;
                    this.projeto = pedido.projeto;
                    this.descricao = pedido.descricao;
                    this.dataEnvioFinanceiro = pedido.dataEnvioFinanceiro;
                    this.dataRetornoFinanceiro = pedido.dataRetornoFinanceiro;
                    this.situacaoAutorizacao = pedido.situacaoAutorizacao;
                    this.observacoes = pedido.observacoes;
                    this.existentPedido = true;
                    //TODO: mudar de alert para uma popup.
                    alert("Pedido carregado.");
                } catch (e) {
                    if (this.existentPedido) {
                        this.dataChegada = "";
                        this.secretariaSolicitante = "";
                        this.projeto = "";
                        this.descricao = "";
                        this.dataEnvioFinanceiro = "";
                        this.dataRetornoFinanceiro = "";
                        this.situacaoAutorizacao = "";
                        this.observacoes = "";
                        this.existentPedido = false;
                    }
                }
            }
        }, 800),

        async createPedido() {
            if (!this.existentPedido && this.numero && this.tipo) {
                try {
                    const {pedido} = await api.pedidos.createPedido({
                        numero: this.numero,
                        tipo: this.tipo,
                        dataChegada: this.dataChegada,
                        secretariaSolicitante: this.secretariaSolicitante,
                        projeto: this.projeto,
                        descricao: this.descricao,
                        dataEnvioFinanceiro: this.dataEnvioFinanceiro,
                        dataRetornoFinanceiro: this.dataRetornoFinanceiro,
                        situacaoAutorizacao: this.situacaoAutorizacao,
                        observacoes: this.observacoes,
                    });
                    this.existentPedido = !!pedido;
                    //TODO: mudar de alert para uma popup.
                    alert("Pedido gravado.");
                } catch (e) {
                    //TODO: mudar de alert para uma popup.
                    alert("Ocorreu um erro ao gravar o pedido.");
                }
            }
        },

        async updatePedido() {
            if (this.existentPedido && this.numero && this.tipo) {
                try {
                    const {pedido} = await api.pedidos.updatePedido({
                        numero: this.numero,
                        tipo: this.tipo,
                        dataChegada: this.dataChegada,
                        secretariaSolicitante: this.secretariaSolicitante,
                        projeto: this.projeto,
                        descricao: this.descricao,
                        dataEnvioFinanceiro: this.dataEnvioFinanceiro,
                        dataRetornoFinanceiro: this.dataRetornoFinanceiro,
                        situacaoAutorizacao: this.situacaoAutorizacao,
                        observacoes: this.observacoes,
                    });
                    this.existentPedido = !!pedido;
                    //TODO: mudar de alert para uma popup.
                    alert("Pedido alterado.");
                } catch (e) {
                    //TODO: mudar de alert para uma popup.
                    alert("Ocorreu um erro ao alterar o pedido.");
                }
            }
        },

        async deletePedido() {
            if (this.existentPedido && this.numero && this.tipo) {
                if (!confirm(`Deseja realmente excluir a ${this.tipo} nº ${this.numero}?`)) return;

                try {
                    await api.pedidos.deletePedido(this.tipo, this.numero);
                    this.clearForm();
                    //TODO: mudar de alert para uma popup.
                    alert("Pedido excluído.");
                } catch (e) {
                    //TODO: mudar de alert para uma popup.
                    alert("Ocorreu um erro ao excluir o pedido.");
                }
            }
        },

        clearForm() {
            this.numero = "";
            this.tipo = "SE";
            this.dataChegada = "";
            this.secretariaSolicitante = "";
            this.projeto = "";
            this.descricao = "";
            this.dataEnvioFinanceiro = "";
            this.dataRetornoFinanceiro = "";
            this.situacaoAutorizacao = "";
            this.observacoes = "";
            this.existentPedido = false;
            this.$refs.numeroInput.focus();
        },
    },

    mounted() {
        this.$refs.numeroInput.focus();
    },
};
</script>
