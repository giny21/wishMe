<template>
    <router-link :to="addUrl" class="c-wish-add bg-success">
        <span class="plus">
            <i class="fas fa-plus"></i> 
        </span>
        <span class="icon">
            <i class="fas fa-gift"></i>
        </span>
    </router-link>
</template>

<script>
import Sticky from 'vue-sticky-directive'

export default {
    directives: {
        Sticky
    },
    computed: {
        addUrl: function(){
            if(this.$route.name == 'Wishlist')
                return this.$router.history.current.path + '/wish/create';
            
            return this.$router.history.current.path + '/create';
        }
    }
}
</script>

<style scoped>
    .c-wish-add{
        width: 45px;
        height: 65px;
        color: white;
        border-radius: 100px 0px 0px 100px;
        font-size: 20px;
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