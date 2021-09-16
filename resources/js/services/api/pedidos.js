/**
 * Tokens de cancelamento para que, quando os comandos getPedidos e getPedidos forem chamados pela segunda
 * vez enquanto a primeira chamada não tiver sido concluída, a primeira chamada possa ser cancelada.
 */
let getPedidosCancelTokenSource;
let getPedidoCancelTokenSource;

const pedidos = {
    getPedidos: (filtro = {}) => {
        getPedidosCancelTokenSource?.cancel();
        getPedidosCancelTokenSource = window.axios.CancelToken.source();
        return window.axios.get("/api/pedidos", {
            params: filtro,
            cancelToken: getPedidosCancelTokenSource.token,
        })
            .then(response => response.data);
    },

    getPedido: (tipo, numero) => {
        getPedidoCancelTokenSource?.cancel();
        getPedidoCancelTokenSource = window.axios.CancelToken.source();
        return window.axios.get(`/api/pedidos/${tipo}/${numero}`, {
            cancelToken: getPedidoCancelTokenSource.token,
        })
            .then(response => response.data);
    },

    createPedido: (pedido) => window.axios.post("/api/pedidos", pedido)
        .then(response => response.data),

    updatePedido: (pedido) => window.axios.post(`/api/pedidos/${pedido.tipo}/${pedido.numero}`, {
        _method: "PATCH",
        ...pedido,
    })
        .then(response => response.data),

    deletePedido: (tipo, numero) => window.axios.post(`/api/pedidos/${tipo}/${numero}`, {
        _method: 'DELETE',
    })
        .then(response => response.data),
};

export default pedidos;
