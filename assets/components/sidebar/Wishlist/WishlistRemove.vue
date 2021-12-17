<template>
    <button 
        class="btn btn-danger btn-block c-wishlist-remove" 
        v-on:click="remove"
        v-if="wishlist.init"     
    >
        Usuń listę
    </button>
</template>

<script>
    import store from '../../../store/store';
    import Wishlist from '../../../store/wishlist/entity';
    import caller from '../../../store/wishlist/caller';

    export default {
        props:{
            wishlist: Wishlist
        },

        data(){
            return {
                store: store.state
            }
        },

        methods: {
            remove(){
                caller.remove(this.wishlist.id);
                store.remove('wishlists', this.wishlist);
                let matched = this.$route.matched;
                this.$router.push({ name: matched[matched.length - 2].name });

                for(const wishlistWish of this.wishlist.wishes)
                    store.refresh('wishes', wishlistWish.id);
            }
        }
    }
</script>

<style scoped>
    .btn-block{
        width: 100%;
    }
</style>