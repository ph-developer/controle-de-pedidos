<template>
    <div class="container vh-100">
        <div class="row h-100 align-items-center">
            <div class="col text-center">
                <img src="images/brasao_prefeitura.jpg" alt="Brasão da Prefeitura Municipal de Penápolis">
                <h1>Controle de Pedidos</h1>
                <h3>Prefeitura Municipal de Penápolis</h3>
                <br>
                <button class="btn btn-primary" @click="onNavigateToLogin">Entrar na Aplicação</button>
            </div>
        </div>
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
