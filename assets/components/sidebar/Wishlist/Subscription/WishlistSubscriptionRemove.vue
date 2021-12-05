<template>
    <span 
        class="c-wishlist-subscription-remove"
        v-on:click="remove"
        v-if="canRemove()" 
    >
        <i class="fas fa-user-slash" v-if="wishlist.isOwner(store.user)"></i>
        <i class="fas fa-sign-out-alt" v-else></i>
    </span>
</template>

<script>
import store from '../../../../store/store';
import Wishlist from '../../../../store/wishlist/entity';
import caller from '../../../../store/wishlist/caller';

export default {
    props: {
        wishlist: Wishlist,
        subscription: Object
    },

    data(){
        return {
            store: store.state
        }
    },

    methods: {
        remove(){
            caller
            .removeSubscription(this.wishlist.id, this.subscription.id)
            .then(
                response => {
                    if(!this.wishlist.isOwner(this.store.user)){
                        store.remove('wishlists', this.wishlist);
                        let matched = this.$route.matched;
                        this.$router.push({ name: matched[matched.length - 2].name });
                    }
                    else{
                        let newValue = new Wishlist(response.data.wishlist);
                        store.update('wishlists', this.wishlist.id, newValue); 
                    }
                }
            );
        },

        canRemove(){
            if(this.wishlist.isOwner(this.store.user)){
                if(this.subscription.user.id != this.store.user.id)
                    return true; 
            }
            else{
                if(this.subscription.user.id == this.store.user.id)
                    return true;
            }
            return false;
        },
    }
}
</script>

<style scoped>
</style>