<template>
    <sidebar-layout>
        <content v-if="wish && wish.init">
            <h6>Edytuj życzenie {{wish.name}}</h6>
            <div>
                <wish-edit :wish="wish"></wish-edit>
            </div>
            <div>
                <wish-remove :wish="wish"></wish-remove>
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
    import WishRemove from '../../../../components/sidebar/Wish/WishRemove.vue';
    import WishEdit from '../../../../components/sidebar/Wish/WishEdit.vue';

    export default {
        components: {
            SidebarLayout,
            BSpinner,
            WishRemove,
            WishEdit
        },

        data(){
            return {
                store: store.state
            }
        },

        computed: {
            wish: function(){
                let id = Number(this.$route.params.id);
                return store.get('wishes', id);
            }
        }
    }
</script>