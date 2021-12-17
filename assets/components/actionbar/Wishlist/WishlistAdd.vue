<template>
    <router-link :to="'/list/create'" class="c-wishlist-add bg-success">
        <span class="plus">
            <i class="fas fa-plus"></i> 
        </span>
        <span class="icon">
            <i class="fas fa-clipboard-list"></i>
        </span>
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
        width: 45px;
        height: 65px;
        color: white;
        border-radius: 100px 0px 0px 100px;
        font-size: 17px;
        align-items: center;
        padding-left: 5px;
        display: flex;
        cursor: pointer;
        background-color: #0d6efd;
        text-decoration: none;
    }

    .icon{
        margin-top: 8px;
        margin-left: -4px;
    }

    .plus{
        margin-top: -15px;
        font-size: 14px;
    }
</style>