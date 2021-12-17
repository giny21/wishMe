<template>
    <div class="p-wishlist">
        <div class="col-12 d-flex flex-row flex-wrap wishlist-wrapper" v-if="wishlist && wishlist.init">
            <wish v-for="wishId in wishlist.wishes" :key="wishId" :id="wishId"></wish>    
        </div>
        <div class="col-12 d-flex justify-content-center align-items-center mt-4" v-else>
            <b-spinner variant="primary" label="Spinning"></b-spinner>
        </div>
        <div class="actions-wrapper">
            <actionbar-layout>
                <wish-add wishlist="wishlist"></wish-add>
            </actionbar-layout>
        </div>
        <transition name="slide">
            <router-view></router-view>
        </transition>
    </div>
</template>

<script>
    import store from '../../../store/store';
    import { BSpinner } from 'bootstrap-vue';
    import ActionbarLayout from '../../../layouts/Actionbar.vue';
    import Wish from '../../../components/content/Wish/Wish.vue';
    import WishAdd from '../../../components/actionbar/Wish/WishAdd.vue';

    export default {
        components: {  
            BSpinner,
            ActionbarLayout,
            Wish,
            WishAdd
        },
        data(){
            return {
                store: store.state
            }
        },
        computed: {
            wishlist: function(){
                let id = Number(this.$route.params.id);
                return store.get('wishlists', id)
            }
        }
    }
</script>

<style scoped>
    .p-wishlist{
        position: relative;
        min-height: calc(100vh - 105px);
    }

    .wishlist-wrapper
    {
        max-width: calc(100% - 30px);
    }

    .actions-wrapper
    {
        max-width: 30px;
    }

    .slide-leave-active, .slide-enter-active {
        transition: 1s;
    }
    .slide-enter {
        transform: translate(110%, 0);
    }
    .slide-leave-to {
        transform: translate(110%, 0);
    }
</style>