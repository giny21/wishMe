<template>
    <sidebar-layout>
        <content v-if="wishlist && wishlist.init">
            <h6>Znajomi z listy {{wishlist.name}}</h6>
            <div class="overflow">
                <wishlist-subscription 
                    v-for="subscription in wishlist.subscriptions" 
                    :key="subscription.id" 
                    :wishlist="wishlist"
                    :subscription="subscription"
                >
                </wishlist-subscription>
                <wishlist-subscription-create :wishlist="wishlist"></wishlist-subscription-create>
            </div>
        </content>
        <div class="d-flex mt-5 justify-content-center" v-else>
            <b-spinner variant="primary" label="Spinning"></b-spinner>
        </div>
    </sidebar-layout>
</template>

<script>
    import SidebarLayout from '../../../../layouts/Sidebar.vue';
    import store from '../../../../store/store';
    import { BSpinner } from 'bootstrap-vue';
    import WishlistSubscription from '../../../../components/sidebar/Wishlist/Subscription/WishlistSubscription.vue';
    import WishlistSubscriptionCreate from '../../../../components/sidebar/Wishlist/Subscription/WishlistSubscriptionCreate.vue';

    export default {
        components: {
            SidebarLayout,
            BSpinner,
            WishlistSubscription,
            WishlistSubscriptionCreate
        },

        data(){
            return {
                store: store.state
            }
        },

        computed: {
            wishlist: function(){
                let id = Number(this.$route.params.id);
                return store.get('wishlists', id);
            }
        }
    }
</script>