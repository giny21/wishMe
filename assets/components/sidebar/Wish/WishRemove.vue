<template>
    <button 
        class="btn btn-danger btn-block c-wish-remove" 
        v-on:click="remove" 
    >
        Usuń życzenie
    </button>
</template>

<script>
    import store from '../../../store/store';
    import Wish from '../../../store/wish/entity';
    import caller from '../../../store/wish/caller';

    export default {
        props:{
            wish: Wish
        },

        data(){
            return {
                store: store.state
            }
        },

        methods: {
            remove(){
                caller.remove(this.wish.id);
                store.remove('wishes', this.wish);
                let matched = this.$route.matched;
                this.$router.push({ name: matched[matched.length - 2].name });

                for(const wishWishlist of this.wish.wishlists)
                    store.refresh('wishlists', wishWishlist.id);
            }
        }
    }
</script>

<style scoped>
    .btn-block{
        width: 100%;
    }
</style>