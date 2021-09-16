const app = {
    getCsrfCookie: () => window.axios.get('/sanctum/csrf-cookie'),
};

export default app;
