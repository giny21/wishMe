<template>
    <sidebar-layout>
        <content v-if="wishlist.init">
            <h6>Dodaj życzenie</h6>
            <wish-create :wishlist="wishlist"></wish-create>
        </content>
    </sidebar-layout>
</template>

<script>
    import SidebarLayout from '../../../../../layouts/Sidebar.vue';
    import store from '../../../../../store/store';
    import { BSpinner } from 'bootstrap-vue';
    import WishCreate from '../../../../../components/sidebar/Wish/WishCreate.vue';

    export default {
        components: {
            SidebarLayout,
            BSpinner,
            WishCreate
        },

        data(){
            return {
                store: store.state
            }
        },
        
        computed: {
            wishlist: function(){
                return store.get('wishlists', this.$route.params.id)
            }
        }
    }
</script>