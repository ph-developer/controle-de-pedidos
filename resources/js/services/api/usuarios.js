const usuarios = {
    getUsuarios: (filtro = {}) => window.axios.get("/api/usuarios", {
        params: filtro,
    })
        .then(response => response.data),

    getUsuario: (id) => window.axios.get(`/api/usuarios/${id}`)
        .then(response => response.data),

    createUsuario: (usuario) => window.axios.post("/api/usuarios", usuario)
        .then(response => response.data),

    updateUsuario: (usuario) => window.axios.post(`/api/usuarios/${usuario.id}`, {
        _method: "PATCH",
        ...usuario,
    })
        .then(response => response.data),

    deleteUsuario: (id) => window.axios.post(`/api/usuarios/${id}`, {
        _method: "DELETE",
    })
        .then(response => response.data),
};

export default usuarios;
