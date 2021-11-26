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
            <c-placeholder></c-placeholder>
        </div>
    </div>
</template>

<script>
import Header from '../components/top/header/Header';
import Menu from '../components/top/menu/Menu';
import Content from '../components/content/Content';

export default {
    components: {
        'c-header': Header,
        'c-menu': Menu,
        'c-placeholder': Content
    }
}
</script>

<style scoped>
    .l-dashboard{
        padding: 0px;
    }
</style>