<template>
    <div>
        <NavBar/>
        <div class="container">
            <div class="row">
                <div class="col">
                    <h3 class="my-4">Pedidos</h3>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <form @submit.prevent>
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label col-form-label-sm">Número do Pedido</label>
                                <input class="form-control form-control-sm" ref="numeroInput" type="text"
                                       v-model="numero" @input="debounceSearchPedido" :disabled="isBusy">
                            </div>

                            <div class="col">
                                <label class="form-label col-form-label-sm">Tipo do Pedido</label>
                                <select class="form-select form-select-sm" v-model="tipo" @change="debounceSearchPedido"
                                        :disabled="isBusy">
                                    <option value="SE">SE</option>
                                    <option value="RM">RM</option>
                                </select>
                            </div>

                            <div class="col">
                                <label class="form-label col-form-label-sm">Data de Chegada</label>
                                <input class="form-control form-control-sm" type="date" v-model="dataChegada"
                                       :disabled="isBusy">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label col-form-label-sm">Secretaria Solicitante</label>
                                <input class="form-control form-control-sm" type="text" v-model="secretariaSolicitante"
                                       :disabled="isBusy">
                            </div>

                            <div class="col">
                                <label class="form-label col-form-label-sm">Secretaria Solicitante</label>
                                <input class="form-control form-control-sm" type="text" v-model="projeto"
                                       :disabled="isBusy">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label col-form-label-sm">Descrição</label>
                                <textarea class="form-control form-control-sm no-resize" v-model="descricao" rows="3"
                                          :disabled="isBusy"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label col-form-label-sm">Data de Envio ao Financeiro</label>
                                <input class="form-control form-control-sm" type="date" v-model="dataEnvioFinanceiro"
                                       :disabled="isBusy">
                            </div>

                            <div class="col">
                                <label class="form-label col-form-label-sm">Data de Retorno do Financeiro</label>
                                <input class="form-control form-control-sm" type="date" v-model="dataRetornoFinanceiro"
                                       :disabled="isBusy">
                            </div>

                            <div class="col">
                                <label class="form-label col-form-label-sm">Situação da Autorização</label>
                                <input class="form-control form-control-sm" type="text" v-model="situacaoAutorizacao"
                                       :disabled="isBusy">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label col-form-label-sm">Observações</label>
                                <textarea class="form-control form-control-sm no-resize" v-model="observacoes" rows="3"
                                          :disabled="isBusy"/>
                            </div>
                        </div>

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
import toaster from "../services/toaster";

/**
 * Página Pedidos.
 * Página que contém um formulário para consulta, cadastro, edição e exclusão de pedidos.
 */
export default {
    name: "Pedidos",

    components: {NavBar},

    data() {
        return {
            // Indicação de que há um comando em execução.
            isBusy: false,

            // Indicação de que o pedido estão carregado ou não.
            existentPedido: false,

            // Campos do formulário.
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
        /**
         * Realiza a busca do pedido com base nos campos "tipo" e "numero", e caso encontre, preenche os campos com os
         * dados.retornados da API.
         * A função utiliza da função "debounce", proveniente da biblioteca "lodash" para que a função seja executada
         * após um intervalo de 800ms sem chamá-la, evitando assim que o sistema faça um "spam" no banco de dados,
         * evitando problemas de carregamento, de performance, e melhorando a experiência do usuário.
         */
        debounceSearchPedido: _.debounce(async function () {
            // Cancela o comando se o campo "numero" ou o campo "tipo" estiverem em branco.
            if (!this.numero || !this.tipo) return;

            try {
                // Faz uma requisição à API para buscar um pedido com base no tipo e número informado no formulário.
                const {pedido} = await api.pedidos.getPedido(this.tipo, this.numero);

                // Preenche o formulário com os dados do pedido encontrado, caso o pedido esteja cadastrado.
                this.dataChegada = pedido.dataChegada;
                this.secretariaSolicitante = pedido.secretariaSolicitante;
                this.projeto = pedido.projeto;
                this.descricao = pedido.descricao;
                this.dataEnvioFinanceiro = pedido.dataEnvioFinanceiro;
                this.dataRetornoFinanceiro = pedido.dataRetornoFinanceiro;
                this.situacaoAutorizacao = pedido.situacaoAutorizacao;
                this.observacoes = pedido.observacoes;
                this.existentPedido = true;

                // Exibe uma mensagem de sucesso caso a pedido seja encontrado e carregado.
                toaster.displaySuccess("Pedido carregado.");
            } catch (e) {
                // Limpa o formulário caso o pedido não seja encontrado e exista um pedido já carregado..
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
        }, 800),

        /**
         * Cria um novo pedido.
         *
         * @returns {Promise<void>}
         */
        async createPedido() {
            // Cancela o comando se o campo "numero" ou o campo "tipo" estiverem em branco, se existir um pedido já
            // carregado ou se outro comando já está em execução.
            if (this.existentPedido || !this.numero || !this.tipo || this.isBusy) return;

            this.isBusy = true;
            try {
                // Faz uma requisição à API para criar um novo pedido.
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

                // Define no estado da página que o pedido foi carregado, caso a operação seja concluída.
                this.existentPedido = !!pedido;

                // Exibe uma mensagem de sucesso caso a operação seja concluída.
                toaster.displaySuccess("Pedido gravado.");
            } catch (e) {
                // Exibe uma mensagem de erro caso a operação não seja concluída.
                toaster.displayError("Ocorreu um erro ao gravar o pedido.");
            }
            this.isBusy = false;
        },

        /**
         * Atualiza um pedido existente e carregado.
         *
         * @returns {Promise<void>}
         */
        async updatePedido() {
            // Cancela o comando se o campo "numero" ou o campo "tipo" estiverem em branco, se não existir um pedido já
            // carregado ou se outro comando já está em execução.
            if (!this.existentPedido || !this.numero || !this.tipo || this.isBusy) return;

            this.isBusy = true;
            try {
                // Faz uma requisição à API para atualizar o pedido carregado.
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

                // Define no estado da página que o pedido foi carregado, caso a operação seja concluída.
                this.existentPedido = !!pedido;

                // Exibe uma mensagem de sucesso caso a operação seja concluída.
                toaster.displaySuccess("Pedido alterado.");
            } catch (e) {
                // Exibe uma mensagem de erro caso a operação não seja concluída.
                toaster.displayError("Ocorreu um erro ao alterar o pedido.");
            }
            this.isBusy = false;
        },

        /**
         * Exclui um pedido existente e carregado.
         *
         * @returns {void}
         */
        deletePedido() {
            // Cancela o comando se o campo "numero" ou o campo "tipo" estiverem em branco, se não existir um pedido já
            // carregado ou se outro comando já está em execução.
            if (!this.existentPedido || !this.numero || !this.tipo || this.isBusy) return;

            // Questiona o usuário confirmando a exclusão.
            toaster.displayConfirm(
                `Deseja realmente excluir a ${this.tipo} nº ${this.numero}?`,
                // Operação que será executada caso o usuário pressione "Sim".
                async () => {
                    this.isBusy = true;
                    try {
                        // Faz uma requisição à API para excluir o pedido carregado.
                        await api.pedidos.deletePedido(this.tipo, this.numero);

                        // Limpa o fomulario de pedido, caso a operação seja concluída.
                        this.clearForm();

                        // Exibe uma mensagem de sucesso caso a operação seja concluída.
                        toaster.displaySuccess("Pedido excluído.");
                    } catch (e) {
                        // Exibe uma mensagem de erro caso a operação não seja concluída.
                        toaster.displayError("Ocorreu um erro ao excluir o pedido.");
                    }
                    this.isBusy = false;
                },
            );
        },

        /**
         * Limpa o formulário de pedido.
         */
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

            // Muda o foco para o input numero.
            this.$refs.numeroInput.focus();
        },
    },

    mounted() {
        // Muda o foco para o input numero.
        this.$refs.numeroInput.focus();
    },
};
</script>
