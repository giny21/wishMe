<template>
    <sidebar-layout>
        <content>
            <h6>Dodaj życzenie</h6>
            <wish-create></wish-create>
        </content>
    </sidebar-layout>
</template>

<script>
    import SidebarLayout from '../../../../layouts/Sidebar.vue';
    import store from '../../../../store/store';
    import { BSpinner } from 'bootstrap-vue';
    import WishCreate from '../../../../components/sidebar/Wish/WishCreate.vue';

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
        }
    }
</script>