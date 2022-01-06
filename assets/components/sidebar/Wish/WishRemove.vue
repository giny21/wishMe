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
                for(const wishlistId of this.wish.wishlists){
                    let wishlist = store.get('wishlists', wishlistId);
                    if(wishlist.init){
                        wishlist.wishes = wishlist.wishes.filter( id => this.wish.id != id);
                        store.update('wishlists', wishlist.id, wishlist);
                    }
                }

                caller.remove(this.wish.id);
                store.remove('wishes', this.wish);

                let matched = this.$route.matched;
                this.$router.push({ name: matched[matched.length - 2].name });
            }
        }
    }
</script>

<style scoped>
    .btn-block{
        width: 100%;
    }
</style>