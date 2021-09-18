import {AxiosResponse} from "axios";

import app from "./app";
import auth from "./auth";
import pedidos from "./pedidos";
import usuarios from "./usuarios";

/**
 * Serviço de consulta à API.
 *
 * @type {{app: {getCsrfCookie: (function(): Promise<AxiosResponse<void>>)}, auth: {doLogin: (function(string, string):
 * Promise<AxiosResponse<void>>), doLogout: (function(): Promise<AxiosResponse<void>>), getUsuario: (function():
 * Promise<AxiosResponse<{usuario: Object}>>)}, pedidos: {createPedido: (function(Object): Promise<AxiosResponse<{
 * pedido: Object}>>), updatePedido: (function(Object): Promise<AxiosResponse<{pedido: Object}>>), deletePedido: (
 * function(string, (int|string)): Promise<AxiosResponse<{result: boolean}>>), getPedidos: (function((Object|null)=):
 * Promise<AxiosResponse<{pedidos: Object[]}>>), getPedido: (function(string, (string|int)): Promise<AxiosResponse<{
 * pedido: Object}>>)}, usuarios: {deleteUsuario: (function((int|string)): Promise<AxiosResponse<{result: boolean}>>),
 * getUsuarios: (function((Object|null)=): Promise<AxiosResponse<{usuarios: Object[]}>>), getUsuario: (function(
 * (int|string)): Promise<AxiosResponse<{usuario: Object}>>), createUsuario: (function(Object): Promise<AxiosResponse<{
 * usuario: Object}>>), updateUsuario: (function(Object): Promise<AxiosResponse<{usuario: Object}>>)}}}
 */
const api = {
    app,
    auth,
    pedidos,
    usuarios,
};

export default api;
