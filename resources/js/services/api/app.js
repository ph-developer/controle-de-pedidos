import {AxiosResponse} from "axios";

/**
 * Módulo de consulta à API referente ao controle do app.
 *
 * @type {{getCsrfCookie: (function(): Promise<AxiosResponse<void>>)}}
 */
const app = {
    /**
     * Faz uma requisição à API em busca do cookie CSRF.
     *
     * @returns {Promise<AxiosResponse<void>>} Resposta da API.
     */
    getCsrfCookie: () => window.axios.get("/sanctum/csrf-cookie"),
};

export default app;
