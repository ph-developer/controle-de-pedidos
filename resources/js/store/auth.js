const auth = {
    namespaced: true,

    state: {
        // Indicador de que o estado da aplicação está sendo carregado.
        isLoading: true,

        // Indicação de que o usuário está autenticado.
        isAuthenticated: false,

        // Usuário autenticado no momento.
        usuario: null,
    },

    getters: {
        /**
         * Retorna o status do carregamento do estado da aplicação.
         *
         * @param state Estado da aplicação.
         * @returns {boolean} Status do carregamento do estado da aplicação.
         */
        isLoading: (state) => state.isLoading,

        /**
         * Retorna o status de autenticação do usuário.
         *
         * @param state Estado da aplicação.
         * @returns {boolean} Status da autenticação do usuário.
         */
        isAuthenticated: (state) => state.isAuthenticated,

        /**
         * Retorna o usuário autenticado no momento.
         *
         * @param state Estado da aplicação.
         * @returns {null|object} Usuário autenticado no momento.
         */
        usuario: (state) => state.usuario,

        /**
         * Retorna a informação de se o usuário é administrador.
         *
         * @param state Estado da aplicação.
         * @returns {boolean} Informação de se o usuário é administrador.
         */
        isAdmin: (state) => state.usuario?.email === "admin@admin.dev",
    },

    mutations: {
        /**
         * Altera o status do carregamento do estado da aplicação.
         *
         * @param state Estado da aplicação.
         * @param {boolean} value Status do carregamento do estado da aplicação.
         */
        setIsLoading(state, value) {
            state.isLoading = value;
        },

        /**
         * Altera o status de autenticação do usuário.
         *
         * @param state Estado da aplicação.
         * @param {boolean} value Status de autenticação do usuário.
         */
        setIsAuthenticated(state, value) {
            state.isAuthenticated = value;
        },

        /**
         * Altera o usuário autenticado no momento.
         *
         * @param state Estado da aplicação.
         * @param {null|object} value Usuário autenticado no momento ou null.
         */
        setUsuario(state, value) {
            state.usuario = value;
        },
    },
};

export default auth;
