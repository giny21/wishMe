<template>
    <sidebar-layout>
        <content v-if="wish && wish.init">
            <h6>Znajomi związani z życzeniem {{wish.name}}</h6>
            <div class="overflow" v-if="owner && owner.id != store.user.id">
                <wish-subscription 
                    v-for="subscription in wish.subscriptions" 
                    :key="subscription.id" 
                    :wish="wish"
                    :subscription="subscription"
                    :owner="owner"
                >
                </wish-subscription>
                <div v-if="wish.subscriptions.length - 1 == 0">
                    Nikt jeszcze nie spełnia tego życzenia
                </div>
                <wish-subscription-create :wish="wish"></wish-subscription-create>
            </div>
            <div v-else-if="wish.subscriptions.length - 1 > 0">
                Święty Mikołaj i jego pomocnicy
            </div>
            <div v-else>
                Nikt jeszcze nie spełnia tego życzenia
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
    import WishSubscription from '../../../../components/sidebar/Wish/Subscription/WishSubscription.vue';
    import WishSubscriptionCreate from '../../../../components/sidebar/Wish/Subscription/WishSubscriptionCreate.vue';

    export default {
        components: {
            SidebarLayout,
            BSpinner,
            WishSubscription,
            WishSubscriptionCreate
        },

        data(){
            return {
                store: store.state
            }
        },

        computed: {
            wish: function(){
                let id = Number(this.$route.params.wish);
                return store.get('wishes', id);
            },
            wishlists: function(){
                return this
                    .wish
                    .wishlists
                    .map(
                        wishlistId => store.get('wishlists', wishlistId)
                    );
            },
            owner: function(){
                if(this.wish.wishlists.length === 0)
                    return this.store.user;

                let wishlists = this
                    .wishlists
                    .filter(
                        wishlist => wishlist.init
                    );

                if(wishlists.length > 0)
                    return wishlists[0].getOwner();
            }
        }
    }
</script>