<template>
    <sidebar-layout>
        <content v-if="wish && wish.init">
            <h6>Linki życzenia {{wish.name}}</h6>
            <div class="overflow">
                <div v-if="wish.links.length > 0">
                    <wish-link 
                        v-for="link in wish.links" 
                        :key="link.id" 
                        :wish="wish"
                        :link="link"
                        :owner="owner"
                    >
                    </wish-link>
                </div>
                <div v-else>
                    To życzenie nie ma żadnych linków
                </div>
                <wish-link-create :wish="wish" :owner="owner"></wish-link-create>
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
    import WishLink from '../../../../components/sidebar/Wish/Link/WishLink.vue';
    import WishLinkCreate from '../../../../components/sidebar/Wish/Link/WishLinkCreate.vue';

    export default {
        components: {
            SidebarLayout,
            BSpinner,
            WishLink,
            WishLinkCreate
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