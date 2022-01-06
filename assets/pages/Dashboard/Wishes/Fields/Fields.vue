<template>
    <sidebar-layout>
        <content v-if="wish && wish.init">
            <h6>Cechy życzenia {{wish.name}}</h6>
            <div class="overflow">
                <div v-if="wish.fields.length > 0">
                    <wish-field 
                        v-for="field in wish.fields" 
                        :key="field.id" 
                        :wish="wish"
                        :field="field"
                        :owner="owner"
                    >
                    </wish-field>
                </div>
                <div v-else>
                    To życzenie nie ma żadnych dodatkowych cech
                </div>
                <wish-field-create :wish="wish" :owner="owner"></wish-field-create>
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
    import WishField from '../../../../components/sidebar/Wish/Field/WishField.vue';
    import WishFieldCreate from '../../../../components/sidebar/Wish/Field/WishFieldCreate.vue';

    export default {
        components: {
            SidebarLayout,
            BSpinner,
            WishField,
            WishFieldCreate
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