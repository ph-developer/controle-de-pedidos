<template>
    <div>
        <NavBar/>
        <div class="container">
            <div class="row">
                <div class="col">
                    <br>
                    <h3>Pedidos</h3>
                    <br>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <form @submit.prevent>
                        <div class="row">
                            <div class="col">
                                <label class="form-label">Número do Pedido</label>
                                <input class="form-control form-control-sm" ref="numeroInput" type="text"
                                       v-model="numero" @input="debounceSearchPedido" :disabled="isBusy">
                            </div>

                            <div class="col">
                                <label class="form-label">Tipo do Pedido</label>
                                <select class="form-select form-select-sm" v-model="tipo" @change="debounceSearchPedido"
                                        :disabled="isBusy">
                                    <option value="SE">SE</option>
                                    <option value="RM">RM</option>
                                </select>
                            </div>

                            <div class="col">
                                <label class="form-label">Data de Chegada</label>
                                <input class="form-control form-control-sm" type="date" v-model="dataChegada"
                                       :disabled="isBusy">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label class="form-label">Secretaria Solicitante</label>
                                <input class="form-control form-control-sm" type="text" v-model="secretariaSolicitante"
                                       :disabled="isBusy">
                            </div>

                            <div class="col">
                                <label class="form-label">Secretaria Solicitante</label>
                                <input class="form-control form-control-sm" type="text" v-model="projeto"
                                       :disabled="isBusy">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label class="form-label">Descrição</label>
                                <textarea class="form-control form-control-sm" v-model="descricao" rows="3"
                                          :disabled="isBusy"/>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label class="form-label">Data de Envio ao Financeiro</label>
                                <input class="form-control form-control-sm" type="date" v-model="dataEnvioFinanceiro"
                                       :disabled="isBusy">
                            </div>

                            <div class="col">
                                <label class="form-label">Data de Retorno do Financeiro</label>
                                <input class="form-control form-control-sm" type="date" v-model="dataRetornoFinanceiro"
                                       :disabled="isBusy">
                            </div>

                            <div class="col">
                                <label class="form-label">Situação da Autorização</label>
                                <input class="form-control form-control-sm" type="text" v-model="situacaoAutorizacao"
                                       :disabled="isBusy">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label class="form-label">Observações</label>
                                <textarea class="form-control form-control-sm" v-model="observacoes" rows="3"
                                          :disabled="isBusy"/>
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col">
                                <button v-if="!existentPedido" class="btn btn-sm btn-primary" type="button"
                                        @click="createPedido" :disabled="!numero || !tipo || isBusy">
                                    Gravar
                                </button>

                                <button v-else class="btn btn-sm btn-primary" type="button" @click="updatePedido"
                                        :disabled="!numero || !tipo || isBusy">
                                    Alterar
                                </button>

                                <button class="btn btn-sm btn-danger" type="button" @click="deletePedido"
                                        :disabled="!existentPedido || !numero || !tipo || isBusy">
                                    Excluir
                                </button>

                                <button class="btn btn-sm btn-secondary" type="button" @click="clearForm"
                                        :disabled="isBusy">
                                    Limpar
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
import _ from "lodash";
import NavBar from "../components/NavBar";

export default {
    name: "Pedidos",

    components: {NavBar},

    data() {
        return {
            isBusy: false,
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
            if (this.existentPedido || !this.numero || !this.tipo || this.isBusy) return;

            this.isBusy = true;
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
            this.isBusy = false;
        },

        async updatePedido() {
            if (!this.existentPedido || !this.numero || !this.tipo || this.isBusy) return;

            this.isBusy = true;
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
            this.isBusy = false;
        },

        async deletePedido() {
            if (!this.existentPedido || !this.numero || !this.tipo || this.isBusy) return;
            if (!confirm(`Deseja realmente excluir a ${this.tipo} nº ${this.numero}?`)) return;

            this.isBusy = true;
            try {
                await api.pedidos.deletePedido(this.tipo, this.numero);
                this.clearForm();

                //TODO: mudar de alert para uma popup.
                alert("Pedido excluído.");
            } catch (e) {
                //TODO: mudar de alert para uma popup.
                alert("Ocorreu um erro ao excluir o pedido.");
            }
            this.isBusy = false;
        },

        clearForm() {
            this.isBusy = true;
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
            this.isBusy = false;
            this.$refs.numeroInput.focus();
        },
    },

    mounted() {
        this.$refs.numeroInput.focus();
    },
};
</script>

<style lang="scss" scoped>
textarea {
    resize: none;
}
</style>
