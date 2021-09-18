import {AxiosResponse} from "axios";

/**
 * Módulo de consulta à API referente ao controle de usuários.
 *
 * @type {{deleteUsuario: (function((int|string)): Promise<AxiosResponse<{result: boolean}>>), getUsuarios:
 * (function((Object|null)=): Promise<AxiosResponse<{usuarios: Object[]}>>), getUsuario: (function((int|string)):
 * Promise<AxiosResponse<{usuario: Object}>>), createUsuario: (function(Object): Promise<AxiosResponse<{usuario:
 * Object}>>), updateUsuario: (function(Object): Promise<AxiosResponse<{usuario: Object}>>)}}
 */
const usuarios = {
    /**
     * Faz uma requisição à API e retorna os usuários cadastrados.
     *
     * @param {object|null} filtro Filtro de busca. os atributos devem possuir os nomes dos atributos da entidade.
     * @returns {Promise<AxiosResponse<{usuarios: object[]}>>} Resposta da API contendo os usuários cadastrados.
     */
    getUsuarios: (filtro = {}) => window.axios.get("/api/usuarios", {
        params: filtro,
    })
        .then(response => response.data),

    /**
     * Faz uma requisição à API e retorna o usuário referente ao "id" informado.
     * Dispara um erro se o usuário não existir.
     *
     * @param {int|string} id Id do usuário.
     * @returns {Promise<AxiosResponse<{usuario: object}>>} Resposta da API contendo o usuário referente ao "id"
     * informado.
     */
    getUsuario: (id) => window.axios.get(`/api/usuarios/${id}`)
        .then(response => response.data),

    /**
     * Faz uma requisição à API para criar um novo usuário.
     *
     * @param {object} usuario Dados do usuário que será criado.
     * @returns {Promise<AxiosResponse<{usuario: object}>>} Resposta da API contendo o usuário criado.
     */
    createUsuario: (usuario) => window.axios.post("/api/usuarios", usuario)
        .then(response => response.data),

    /**
     * Faz uma requisição à API para alterar um usuário.
     *
     * @param {object} usuario Dados do usuário que será alterado.
     * @returns {Promise<AxiosResponse<{usuario: object}>>} Resposta da API contendo o usuário alterado.
     */
    updateUsuario: (usuario) => window.axios.post(`/api/usuarios/${usuario.id}`, {
        _method: "PATCH",
        ...usuario,
    })
        .then(response => response.data),

    /**
     * Faz uma requisição à API para excluir um usuário.
     *
     * @param {int|string} id Id do usuário.
     * @returns {Promise<AxiosResponse<{result: boolean}>>} Resposta da API contendo o resultado da operação.
     */
    deleteUsuario: (id) => window.axios.post(`/api/usuarios/${id}`, {
        _method: "DELETE",
    })
        .then(response => response.data),
};

export default usuarios;
