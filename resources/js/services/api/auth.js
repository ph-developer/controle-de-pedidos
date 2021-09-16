const auth = {
    getUsuario: () => window.axios.get("/api/auth/usuario")
        .then(response => response.data),

    doLogin: (email, senha) => window.axios.post("/api/auth/login", {email, password: senha})
        .then(response => response.data),

    doLogout: () => window.axios.post("/api/auth/logout")
        .then(response => response.data),
};

export default auth;
