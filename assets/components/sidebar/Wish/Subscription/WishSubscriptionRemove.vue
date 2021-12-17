<template>
    <span 
        class="c-wish-subscription-remove clickable"
        v-on:click="remove"
        v-if="canRemove()" 
    >
        <i class="fas fa-user-slash" v-if="wish.isOwner(store.user)"></i>
        <i class="fas fa-sign-out-alt" v-else></i>
    </span>
</template>

<script>
import store from '../../../../store/store';
import Wish from '../../../../store/wish/entity';
import caller from '../../../../store/wish/caller';

export default {
    props: {
        wish: Wish,
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
            .removeSubscription(this.wish.id, this.subscription.id)
            .then(
                response => {
                    let newValue = new Wish(response.data.wish);
                    store.update('wishes', this.wish.id, newValue); 
                }
            );
        },

        canRemove(){
            if(this.wish.isOwner(this.store.user)){
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