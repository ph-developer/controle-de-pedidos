<template>
    <div>
        <div v-if="isLoading">Carregando...</div>
        <router-view v-else></router-view>
        <div class="toast-container position-fixed bottom-0 end-0 p-3" id="toast-container"/>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

/**
 * Layout App.
 * Layout da Single Page Application (SPA). Utilizado como container das páginas (através do router-view), e como
 * container das toasts.
 */
export default {
    name: "App",

    computed: {
        // Valores "calculados" provenientes do estado da aplicação.
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
