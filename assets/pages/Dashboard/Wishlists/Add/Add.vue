<template>
    <sidebar-layout>
        <content v-if="store.wishlistsInitiated">
            <h6>Dodaj listę</h6>
            <wishlist-create></wishlist-create>
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
    import WishlistCreate from '../../../../components/sidebar/Wishlist/WishlistCreate.vue';

    export default {
        components: {
            SidebarLayout,
            BSpinner,
            WishlistCreate
        },

        data(){
            return {
                store: store.state
            }
        }
    }
</script>