<template>
    <div class="p-wishes">
        <div class="col-12 d-flex flex-row flex-wrap wishes-wrapper" v-if="subscribedWishes">
            <wish v-for="wish in subscribedWishes" :key="wish.id" :id="wish.id"></wish>    
        </div>
        <div class="col-12 d-flex justify-content-center align-items-center mt-4" v-else>
            <b-spinner variant="primary" label="Spinning"></b-spinner>
        </div>
        <div class="actions-wrapper">
            <actionbar-layout>
                <wish-add></wish-add>
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
    import caller from '../../../store/wish/caller'; 

    export default {
        components: {  
            Wish,
            BSpinner,
            ActionbarLayout,
            WishAdd,
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
                    .wishes
                    .map(
                        id => store.get('wishes', id)
                    )
            )
        },
        computed: {
            subscribedWishes: function(){
                return this
                .store
                .wishes
                .filter(
                    (wish) => wish.init && wish.isSubscriber(this.store.user)
                );
            }
        }
    }
</script>

<style scoped>
    .p-wishes{
        position: relative;
        min-height: calc(100vh - 105px);
    }

    .wishes-wrapper
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