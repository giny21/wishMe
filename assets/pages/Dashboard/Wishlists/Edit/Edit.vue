<template>
    <sidebar-layout>
        <content v-if="wishlist && wishlist.init">
            <h6>Edytuj listę {{wishlist.name}}</h6>
            <div>
                <wishlist-edit :wishlist="wishlist"></wishlist-edit>
            </div>
            <div>
                <wishlist-remove :wishlist="wishlist"></wishlist-remove>
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
    import WishlistEdit from '../../../../components/sidebar/Wishlist/WishlistEdit.vue';
    import WishlistRemove from '../../../../components/sidebar/Wishlist/WishlistRemove.vue';

    export default {
        components: {
            SidebarLayout,
            BSpinner,
            WishlistEdit,
            WishlistRemove
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