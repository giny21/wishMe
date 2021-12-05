<template>
    <div class="c-wishlist-subscription" :class="{'is-owner': wishlist.isOwner(subscription.user)}">
        <span>
            {{subscription.user.email}}
        </span>
        <wishlist-subscription-remove 
            :wishlist="wishlist" 
            :subscription="subscription"
        >
        </wishlist-subscription-remove>
    </div>
</template>

<script>
import store from '../../../../store/store';
import Wishlist from '../../../../store/wishlist/entity';
import WishlistSubscriptionRemove from './WishlistSubscriptionRemove.vue';

export default {
    components: { 
        WishlistSubscriptionRemove 
    },

    props: {
        wishlist: Wishlist,
        subscription: Object
    },

    data(){
        return {
            store: store.state
        }
    }
}
</script>

<style scoped>
    .is-owner{
        color: goldenrod;
        font-weight: 700;
    }
    .c-wishlist-subscription{
        background-color: white;
        display: flex;
        justify-content: space-between;
        align-content: center;
        padding: 2px 5px;
    }
    .c-wishlist-subscription:nth-child(even) {
        background-color: #e3f2fd;
    }
</style>