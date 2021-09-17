<template>
    <div>
        <img src="images/brasao_prefeitura.jpg" alt="Brasão da Prefeitura Municipal de Penápolis">
        <h1>Controle de Pedidos</h1>
        <h2>Prefeitura Municipal de Penápolis</h2>
        <button @click="onNavigateToLogin">Entrar na Aplicação</button>
    </div>
</template>

<script>
export default {
    name: "Inicio",

    methods: {
        onNavigateToLogin() {
            this.$router.replace({name: "login"});
        },
    },
};
</script>
