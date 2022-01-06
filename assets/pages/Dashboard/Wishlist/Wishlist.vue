<template>
    <div class="p-wishlist">
        <div class="col-12 wishlist-wrapper" v-if="wishlist && wishlist.init">
            <div class="title d-flex flex-row flex-wrap">
                <h4>{{wishlist.name}}</h4>
            </div>
            <div class="wishes d-flex flex-row flex-wrap">
                <wish v-for="wish in wishes" :key="wish.id" :wish="wish"></wish>    
            </div>
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
                let id = Number(this.$route.params.wishlist);
                return store.get('wishlists', id)
            },
            wishes: function(){
                return this
                    .wishlist
                    .wishes
                    .map(
                        wishId => store.get('wishes', wishId)
                    );
            }
        }
    }
</script>

<style scoped>
    .p-wishlist{
        position: relative;
        min-height: calc(100vh - 105px);
    }

    .title{
        width: 100vw;
        align-items: center;
        justify-content: center;
        padding-top: 15px;
    }

    .title h4{
        background-color: #e3f2fd;
        padding: 5px 25px;
        border-radius: 12px;
        border: 1px dotted gray;
        color: darkslategray;
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