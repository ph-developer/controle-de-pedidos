const auth = {
    namespaced: true,

    state: {
        isLoading: true,
        isAuthenticated: false,
        usuario: null,
    },

    getters: {
        isLoading: (state) => state.isLoading,
        isAuthenticated: (state) => state.isAuthenticated,
        usuario: (state) => state.usuario,
        isAdmin: (state) => state.usuario?.email === "admin@admin.dev",
    },

    mutations: {
        setIsLoading(state, value) {
            state.isLoading = value;
        },
        setIsAuthenticated(state, value) {
            state.isAuthenticated = value;
        },
        setUsuario(state, value) {
            state.usuario = value;
        },
    },
};

export default auth;
