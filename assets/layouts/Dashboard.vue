<template>
    <div class="container-fluid l-dashboard">
        <div class="row">
            <div class="col-12">
                <nav class="navbar navbar-dark bg-primary">
                    <c-header></c-header>
                </nav>
            </div>
        </div>
        <div class="row">
            <c-menu></c-menu>
        </div>
        <div class="row">
            <slot></slot>
        </div>
    </div>
</template>

<script>
import Header from '../components/top/header/Header.vue';
import Menu from '../components/top/menu/Menu.vue';

export default {
    components: {
        'c-header': Header,
        'c-menu': Menu
    }
}
</script>

<style scoped>
    .l-dashboard{
        min-height: 100vh;
        padding: 0px;
    }
</style>