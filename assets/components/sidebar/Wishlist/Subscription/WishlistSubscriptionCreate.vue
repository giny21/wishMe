<template>
    <form 
        class="form-inline c-wishlist-subscription-add mt-2"
        @submit="submit"
        v-if="canAdd()"
    >
        <div class="input-group">
            <input 
                class="form-control" 
                id="name" 
                name="userEmail" 
                type="email" 
                placeholder="Wpisz email"
                required
                v-model="addArray.userEmail"
            >
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">+</button>
            </div>
        </div>
    </form>
</template>

<script>
// @todo: Validation, indicators
import store from '../../../../store/store';
import Wishlist from '../../../../store/wishlist/entity';
import caller from '../../../../store/wishlist/caller';

export default {
    props: {
        wishlist: Wishlist
    },

    data(){
        return {
            store: store.state,
            addArray: {
                userEmail: ""
            }
        }
    },

    methods: {
        submit(e){
            caller
            .addSubscription(this.wishlist.id, this.addArray)
            .then(
                response => {
                    let newValue = new Wishlist(response.data.wishlist);
                    store.update('wishlists', this.wishlist.id, newValue); 
                }
            );
            e.preventDefault();
        },

        canAdd(){
            return this.wishlist.isOwner(this.store.user);
        }
    }
}
</script>

<style scoped>
    .btn{
        border-radius: 0px 5px 5px 0px;
    }
</style>