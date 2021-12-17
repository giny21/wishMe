<template>
    <div class="p-wishlists">
        <div class="col-12 d-flex flex-row flex-wrap wishlists-wrapper" v-if="subscribedWishlists">
            <wishlist v-for="wishlist in subscribedWishlists" :key="wishlist.id" :wishlist="wishlist"></wishlist>    
        </div>
        <div class="col-12 d-flex justify-content-center align-items-center mt-4" v-else>
            <b-spinner variant="primary" label="Spinning"></b-spinner>
        </div>
        <div class="actions-wrapper">
            <actionbar-layout>
                <wishlist-add></wishlist-add>
            </actionbar-layout>
        </div>
        <transition name="slide">
            <router-view></router-view>
        </transition>
    </div>
</template>

<script>
    import Wishlist from '../../../components/content/Wishlist/Wishlist.vue';
    import store from '../../../store/store';
    import { BSpinner } from 'bootstrap-vue';
    import ActionbarLayout from '../../../layouts/Actionbar.vue';
    import WishlistAdd from '../../../components/actionbar/Wishlist/WishlistAdd.vue';
    import caller from '../../../store/wishlist/caller.js';

    export default {
        components: {  
            Wishlist,
            BSpinner,
            ActionbarLayout,
            WishlistAdd
        },
        data(){
            return {
                store: store.state
            }
        },
        created: function(){
            caller
            .getsPageIds(0, 0, 0)
            .then(
                response => response
                    .data
                    .wishlists
                    .map(
                        id => store.get('wishlists', id)
                    )
            )
        },
        computed: {
            subscribedWishlists: function(){
                return this
                .store
                .wishlists
                .filter(
                    (wishlist) => wishlist.init && wishlist.isSubscriber(this.store.user)
                );
            }
        }
    }
</script>

<style scoped>
    .p-wishlists{
        position: relative;
        min-height: calc(100vh - 105px);
    }

    .wishlists-wrapper
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