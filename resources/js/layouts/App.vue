<template>
    <div v-if="isLoading">Carregando...</div>
    <router-view v-else></router-view>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: "App",

    computed: {
        ...mapGetters({
            isLoading: "auth/isLoading",
        }),
    },
};
</script>
