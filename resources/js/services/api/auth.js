import {AxiosResponse} from "axios";

/**
 * Módulo de consulta à API referente ao controle de autenticação.
 *
 * @type {{doLogin: (function(string, string): Promise<AxiosResponse<void>>), doLogout: (function():
 * Promise<AxiosResponse<void>>), getUsuario: (function(): Promise<AxiosResponse<{usuario: Object}>>)}}
 */
const auth = {
    /**
     * Faz uma requisição à API e retorna o usuário autenticado no momento.
     *
     * @returns {Promise<AxiosResponse<{usuario: object}>>} Resposta da API contendo o usuário autenticado.
     */
    getUsuario: () => window.axios.get("/api/auth/usuario")
        .then(response => response.data),

    /**
     * Faz uma requisição à API para efetuar o login do usuário.
     *
     * @param {string} email E-mail do usuário.
     * @param {string} senha Senha do usuário.
     * @returns {Promise<AxiosResponse<void>>} Resposta da API.
     */
    doLogin: (email, senha) => window.axios.post("/api/auth/login", {email, password: senha})
        .then(response => response.data),

    /**
     * Faz uma requisição à API para efetuar o logout do usuário.
     *
     * @returns {Promise<AxiosResponse<void>>} Resposta da API.
     */
    doLogout: () => window.axios.post("/api/auth/logout")
        .then(response => response.data),
};

export default auth;
