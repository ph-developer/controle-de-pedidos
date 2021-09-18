<template>
    <div>
        <div v-if="isLoading">Carregando...</div>
        <router-view v-else></router-view>
        <div class="toast-container position-fixed bottom-0 end-0 p-3" id="toast-container"/>
    </div>
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

<style lang="scss" scoped>
.toast-container {
    z-index: 11;
}
</style>
