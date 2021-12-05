<template>
    <router-link :to="'/list/add'" class="c-wishlist-add bg-success">
        <i class="fas fa-plus"></i>
    </router-link>
</template>

<script>
import Sticky from 'vue-sticky-directive'

export default {
    directives: {
        Sticky
    }
}
</script>

<style scoped>
    .c-wishlist-add{
        width: 30px;
        height: 50px;
        color: white;
        border-radius: 100px 0px 0px 100px;
        font-size: 20px;
        align-items: center;
        justify-content: center;
        display: flex;
        cursor: pointer;
        background-color: #0d6efd;
        text-decoration: none;
    }
</style>